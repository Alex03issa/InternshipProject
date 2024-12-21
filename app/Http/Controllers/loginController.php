<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class loginController extends Controller
{
    /**
     * Show the sign-in page (for web).
     *
     * @return \Illuminate\View\View
     */
    public function showSignIn()
    {
        return view('login');
    }

    /**
     * Handle the sign-in form submission for web requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signIn(Request $request)
    {
        try {
            Log::info('Sign-in attempt started.');

            // Validate the request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Generate hash for the input email
            $hashedEmail = hash_hmac('sha256', $request->email, env('HASH_SECRET'));

            // Retrieve the user by hashed_email
            $user = User::where('hashed_email', $hashedEmail)->first();

            if ($user) {
                try {
                    // Decrypt the email to validate
                    $encryptedData = Crypt::decryptString($user->email);
                    $data = json_decode($encryptedData, true);

                    if (!isset($data['email']) || !isset($data['hash'])) {
                        Log::error("Invalid email structure for user ID {$user->id}");
                        return redirect()->back()->withErrors(['email' => 'Invalid email structure.']);
                    }

                    $decryptedEmail = Crypt::decryptString($data['email']);
                    if ($decryptedEmail === $request->email) {
                        Log::info("Email matches for user ID {$user->id}.");

                        // Verify the password
                        if (Hash::check($request->password, $user->password)) {
                            Log::info("Password matches for user ID {$user->id}.");

                            // Update timezone if provided
                            if ($request->has('timezone')) {
                                $user->timezone = $request->input('timezone');
                                $user->save();
                                Log::info("Timezone updated for user: {$decryptedEmail}");
                            }

                            // Check if the user is verified
                            if ($user->is_verified == 0) {
                                $this->regenerateVerificationToken($user);
                                return redirect()->route('login')->with('error', 'Your email is not verified. We have sent you a new verification email.');
                            }

                            // Rehash password if necessary
                            if (Hash::needsRehash($user->password)) {
                                $user->password = Hash::make($request->password);
                                $user->save();
                                Log::info("Password rehashed for user: {$decryptedEmail}");
                            }

                            // Authenticate and redirect based on user type
                            Auth::login($user);
                            if ($user->user_type === 'admin') {
                                Log::info("Admin logged in: {$decryptedEmail}");
                                return redirect()->route('filament.admin.pages.dashboard')->with('success', 'Logged in as Admin!');
                            }

                            Log::info("User logged in: {$decryptedEmail}");
                            return redirect()->route('home.verified')->with('success', 'Logged in successfully!');
                        } else {
                            Log::warning("Password mismatch for user ID {$user->id}.");
                            return redirect()->back()->withErrors(['password' => 'Invalid email or password.']);
                        }
                    } else {
                        return redirect()->back()->withErrors(['email' => 'No user found with this email.']);
                    }
                } catch (Exception $e) {
                    Log::error("Failed to decrypt email for user ID {$user->id}: {$e->getMessage()}");
                    return redirect()->back()->withErrors(['email' => 'No user found with this email.']);
                }
            }

            return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        } catch (ValidationException $e) {
            Log::error("Validation error: {$e->getMessage()}");
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (QueryException $e) {
            Log::error("Query error: {$e->getMessage()}");
            return redirect()->back()->with('error', 'There was an issue with your login. Please try again later.');
        } catch (Exception $e) {
            Log::error("Unexpected error: {$e->getMessage()}");
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


     /**
     * Handle API sign-in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiSignIn(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            // Generate hash for the input email
            $hashedEmail = hash_hmac('sha256', $request->email, env('HASH_SECRET'));

            // Retrieve the user by hashed_email
            $user = User::where('hashed_email', $hashedEmail)->first();

            if ($user) {
                // Decrypt and validate email
                $encryptedData = json_decode(Crypt::decryptString($user->email), true);
                if (!isset($encryptedData['email']) || !isset($encryptedData['hash'])) {
                    return response()->json(['success' => false, 'message' => 'Invalid email structure.'], 400);
                }

                $decryptedEmail = Crypt::decryptString($encryptedData['email']);
                if ($decryptedEmail === $request->email) {
                    // Verify password
                    if (Hash::check($request->password, $user->password)) {
                        // Update timezone if provided
                        if ($request->has('timezone')) {
                            $user->timezone = $request->input('timezone');
                            $user->save();
                        }

                        // Check if verified
                        if (!$user->is_verified) {
                            $this->regenerateVerificationToken($user);
                            return response()->json(['success' => false, 'message' => 'Email not verified. Verification email sent.'], 403);
                        }

                        // Rehash password if needed
                        if (Hash::needsRehash($user->password)) {
                            $user->password = Hash::make($request->password);
                            $user->save();
                        }

                        // Generate and encrypt API token
                        $plainToken = $user->createToken('API Token')->plainTextToken;
                        $encryptedToken = Crypt::encryptString($plainToken);

                        return response()->json([
                            'success' => true,
                            'token' => $encryptedToken,
                            'user' => [
                                'id' => $user->id,
                                'email' => $decryptedEmail,
                            ],
                        ], 200);
                    }

                    return response()->json(['success' => false, 'message' => 'Invalid password.'], 401);
                }
            }

            return response()->json(['success' => false, 'message' => 'The provided credentials do not match our records.'], 401);
        } catch (ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->validator->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['success' => false, 'message' => 'Database query error.'], 500);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unexpected error occurred.'], 500);
        }
    }

    /**
     * Log the user out of the application (for web).
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        try {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('homepage')->with('success', 'Logged out successfully!');
        } catch (Exception $e) {
            return redirect()->route('homepage')->with('error', 'An unexpected error occurred while logging out. Please try again.');
        }
    }

    /**
     * Handle API logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiLogout(Request $request)
    {
        try {
            // Revoke the current token being used
            $request->user()->currentAccessToken()->delete();

            return response()->json(['success' => true, 'message' => 'Logged out successfully!'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Unexpected error occurred while logging out.'], 500);
        }
    }

    /**
     * Send verification email.
     *
     * @param \App\Models\User $user
     * @return void
     */

     protected function regenerateVerificationToken($user)
    {
        try {
            // Decrypt email for token generation
            $decryptedEmail = Crypt::decryptString(json_decode(Crypt::decryptString($user->email), true)['email']);

            // Generate new token
            $tokenData = json_encode([
                'user_id' => $user->id,
                'email' => $decryptedEmail,
                'timestamp' => now()->addMinutes(30)->timestamp, // Expiry: 30 minutes
            ]);
            $hmac = hash_hmac('sha256', $tokenData, env('HASH_SECRET'));
            $verificationToken = Crypt::encryptString(json_encode(['data' => $tokenData, 'hmac' => $hmac]));

            // Save the new token
            $user->update(['verification_token' => $verificationToken]);

            // Send the verification email
            $this->sendVerificationEmail($user);

            Log::info("Regenerated verification token and sent email for user ID {$user->id}");
        } catch (Exception $e) {
            Log::error("Failed to regenerate token for user ID {$user->id}: " . $e->getMessage());
        }
    }

     
    protected function sendVerificationEmail(User $user)
    {
        try {
            // Step 1: Decrypt the outer encryption layer
            $encryptedData = Crypt::decryptString($user->email);
            \Log::info("Step 1: Decrypted Outer Layer -> {$encryptedData}");
    
            // Step 2: Decode JSON to extract inner encryption and hash
            $data = json_decode($encryptedData, true);
            \Log::info("Step 2: Decoded JSON Data -> " . print_r($data, true));
    
            if (!isset($data['email']) || !isset($data['hash'])) {
                throw new Exception("Invalid email structure.");
            }
    
            // Step 3: Decrypt the inner encryption layer
            $decryptedEmail = Crypt::decryptString($data['email']);
            \Log::info("Step 3: Decrypted Email -> {$decryptedEmail}");
    
            // Optional: Verify the hash for integrity
            $calculatedHash = hash_hmac('sha256', $decryptedEmail, env('HASH_SECRET'));
            if ($calculatedHash !== $data['hash']) {
                throw new Exception("Hash integrity check failed.");
            }
            \Log::info("Step 4: Hash Verified Successfully");
    
            // Send the verification email
            Mail::to($decryptedEmail)->send(new VerificationMail($user));
            \Log::info("Verification email sent to: " . $decryptedEmail);
    
        } catch (Exception $e) {
            Log::error("Failed to send verification email: " . $e->getMessage());
        }
    }
    
}
