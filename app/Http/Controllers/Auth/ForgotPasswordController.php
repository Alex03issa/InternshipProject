<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We couldn\'t find an account with that email address in our Database.']);
        }

        try {
            $status = Password::sendResetLink($request->only('email'));

            return $status === Password::RESET_LINK_SENT
                ? back()->with('success', 'Password reset link sent successfully. Please check your email.')
                : back()->withErrors(['email' => __($status)]);
        } catch (\Exception $e) {
            // Custom error message when email could not be sent
            return back()->withErrors(['email' => 'We couldn\'t send you an email right now. Try again later or contact us.']);
        }
    }



     /**
     * API version for sending a password reset email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiForgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return response()->json(['success' => true, 'message' => __($status)], 200);
        }

        return response()->json(['success' => false, 'message' => __($status)], 400);
    }
}
