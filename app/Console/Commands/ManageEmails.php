<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ManageEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:manage {action} {email?} {--save : Save the decrypted email back to the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage email encryption and hashing in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $action = $this->argument('action');
        $email = $this->argument('email');
        $saveToDatabase = $this->option('save'); // Capture the --save option

        if (!in_array($action, ['process', 'decrypt'])) {
            $this->error("Invalid action: {$action}. Use 'process' or 'decrypt'.");
            return 1;
        }

        if ($email) {
            // Handle a specific email
            $action === 'process'
                ? $this->processSingleEmail($email)
                : $this->decryptSingleEmail($email, $saveToDatabase);
        } else {
            // Handle all emails
            $action === 'process'
                ? $this->processAllEmails()
                : $this->decryptAllEmails($saveToDatabase);
        }

        return 0;
    }

    /**
     * Process a single email: Encrypt and hash it.
     *
     * @param string $email
     * @return void
     */
    private function processSingleEmail($email)
    {
        $user = DB::table('users')->where('email', $email)->first();

        if (!$user) {
            $this->error("No user found with the email: {$email}");
            return;
        }

        try {
            // Step 1: Generate hash for the email
            $saltedHash = hash_hmac('sha256', $email, env('HASH_SECRET'));
            \Log::info("Step 1: Generated Hash -> {$saltedHash}");

            // Step 2: First encryption of the email
            $firstEncryption = Crypt::encryptString($email);
            \Log::info("Step 2: First Encryption -> {$firstEncryption}");

            // Step 3: Wrap the first encryption and hash in JSON
            $jsonData = json_encode([
                'email' => $firstEncryption,
                'hash' => $saltedHash,
            ]);
            \Log::info("Step 3: JSON Data -> {$jsonData}");

            // Step 4: Second encryption of the JSON data
            $encryptedEmail = Crypt::encryptString($jsonData);
            \Log::info("Step 4: Second Encryption -> {$encryptedEmail}");

            // Step 5: Update the database with encrypted email and hash
            DB::table('users')
                ->where('id', $user->id)
                ->update(['email' => $encryptedEmail, 'hashed_email' => $saltedHash]);
            \Log::info("Step 5: Updated database for user ID {$user->id}");

            $this->info("Successfully processed email for user ID {$user->id}");
        } catch (\Exception $e) {
            Log::error("Failed to process email for user ID {$user->id}: " . $e->getMessage());
            $this->error("Failed to process email for user ID {$user->id}. Check logs for details.");
        }
    }

    /**
     * Process all emails: Encrypt and hash them.
     *
     * @return void
     */
    private function processAllEmails()
    {
        $this->info('Starting email processing for all users...');

        $users = DB::table('users')->get();

        foreach ($users as $user) {
            try {
                // Skip already processed emails
                try {
                    $data = json_decode(Crypt::decryptString($user->email), true);
                    if (is_array($data) && isset($data['email']) && isset($data['hash'])) {
                        $this->info("Email for user ID {$user->id} is already processed. Skipping...");
                        continue;
                    }
                } catch (\Exception $e) {
                    // Not in encrypted format, continue processing
                }

                // Generate hash for the email
                $saltedHash = hash_hmac('sha256', $user->email, env('HASH_SECRET'));

                // Encrypt the email
                $firstEncryption = Crypt::encryptString($user->email);
                $encryptedEmail = Crypt::encryptString(json_encode([
                    'email' => $firstEncryption,
                    'hash' => $saltedHash,
                ]));

                // Update the email and hashed_email in the database
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['email' => $encryptedEmail, 'hashed_email' => $saltedHash]);

                $this->info("Successfully processed email for user ID {$user->id}");
            } catch (\Exception $e) {
                Log::error("Failed to process email for user ID {$user->id}: " . $e->getMessage());
                $this->error("Failed to process email for user ID {$user->id}. Check logs for details.");
            }
        }

        $this->info('Email processing for all users completed!');
    }

    /**
     * Decrypt a single email.
     *
     * @param string $email
     * @return void
     */
    private function decryptSingleEmail($email, $saveToDatabase = false)
    {
        $user = DB::table('users')->where('hashed_email', hash_hmac('sha256', $email, env('HASH_SECRET')))->first();

        if (!$user) {
            $this->error("No user found with the hashed email corresponding to: {$email}");
            return;
        }

        try {
            // Step 1: Decrypt the outer encryption layer
            $encryptedData = Crypt::decryptString($user->email);
            \Log::info("Step 1: Decrypted Outer Layer -> {$encryptedData}");

            // Step 2: Decode JSON to extract inner encryption and hash
            $data = json_decode($encryptedData, true);
            \Log::info("Step 2: Decoded JSON Data -> " . print_r($data, true));

            if (!isset($data['email']) || !isset($data['hash'])) {
                $this->error("Invalid email structure!");
                return;
            }

            // Step 3: Decrypt the inner encryption layer
            $decryptedEmail = Crypt::decryptString($data['email']);
            \Log::info("Step 3: Decrypted Email -> {$decryptedEmail}");

            // Optional: Verify the hash for integrity
            $calculatedHash = hash_hmac('sha256', $decryptedEmail, env('HASH_SECRET'));
            if ($calculatedHash !== $data['hash']) {
                \Log::error("Hash integrity check failed for user ID {$user->id}");
                $this->error("Data integrity check failed!");
                return;
            }
            \Log::info("Step 4: Hash Verified Successfully");

            // Save the decrypted email back to the database if required
            if ($saveToDatabase) {
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['email' => $decryptedEmail]);
                \Log::info("Step 5: Decrypted email saved back to the database for user ID {$user->id}");
            }

            $this->info("Successfully decrypted email for user ID {$user->id}: {$decryptedEmail}");
        } catch (\Exception $e) {
            Log::error("Failed to decrypt email for user ID {$user->id}: " . $e->getMessage());
            $this->error("Failed to decrypt email for user ID {$user->id}. Check logs for details.");
        }
    }


    /**
     * Decrypt all emails in the database.
     *
     * @return void
     */
    private function decryptAllEmails($saveToDatabase = false)
    {
        $this->info('Starting email decryption for all users...');

        $users = DB::table('users')->get();

        foreach ($users as $user) {
            try {
                // Decrypt the outer encryption layer
                $encryptedData = Crypt::decryptString($user->email);

                // Decode JSON and decrypt the inner encryption layer
                $data = json_decode($encryptedData, true);
                if (!isset($data['email'])) {
                    $this->error("Invalid email structure for user ID {$user->id}.");
                    continue;
                }

                $decryptedEmail = Crypt::decryptString($data['email']);

                // Save the decrypted email back to the database if required
                if ($saveToDatabase) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['email' => $decryptedEmail]);
                    \Log::info("Decrypted email saved back to the database for user ID {$user->id}");
                }

                $this->info("Successfully decrypted email for user ID {$user->id}: {$decryptedEmail}");
            } catch (\Exception $e) {
                Log::error("Failed to decrypt email for user ID {$user->id}: " . $e->getMessage());
                $this->error("Failed to decrypt email for user ID {$user->id}. Check logs for details.");
            }
        }

        $this->info('Email decryption for all users completed!');
    }

}