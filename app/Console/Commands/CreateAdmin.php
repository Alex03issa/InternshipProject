<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Support\EmailEncryption;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create
        {--email= : Admin e-mail (defaults to ADMIN_EMAIL)}
        {--password= : Admin password (defaults to ADMIN_PASSWORD, otherwise asked)}
        {--name= : Display name (defaults to ADMIN_NAME)}
        {--username= : Username (defaults to ADMIN_USERNAME)}';

    protected $description = 'Create (or promote) an admin user that can sign in at /login and open /admin';

    public function handle(): int
    {
        if (!config('app.hash_secret')) {
            $this->error('HASH_SECRET is not set in .env. Set it before creating users.');

            return self::FAILURE;
        }

        $email = $this->option('email') ?: config('app.admin.email') ?: $this->ask('Admin e-mail');
        $password = $this->option('password') ?: config('app.admin.password') ?: $this->secret('Admin password (min. 8 characters)');
        $name = $this->option('name') ?: config('app.admin.name', 'Admin');
        $username = $this->option('username') ?: config('app.admin.username', 'admin');

        $validator = Validator::make(
            compact('email', 'password'),
            ['email' => 'required|email', 'password' => 'required|string|min:8']
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        // Same storage scheme as sign-up: encrypted e-mail + HMAC lookup hash.
        $hashedEmail = EmailEncryption::hash($email);
        $user = User::where('hashed_email', $hashedEmail)->first();

        if ($user) {
            $user->forceFill([
                'user_type' => 'admin',
                'is_verified' => true,
                'password' => Hash::make($password),
            ])->save();

            $this->info("Existing user #{$user->id} is now an admin.");

            return self::SUCCESS;
        }

        $user = User::create(EmailEncryption::attributes($email) + [
            'name' => $name,
            'username' => $username,
            'password' => Hash::make($password),
            'user_type' => 'admin',
            'is_verified' => true,
            'provider' => 'sidetoside',
            'timezone' => config('app.timezone', 'UTC'),
        ]);

        $this->info("Admin user #{$user->id} created. Sign in at /login, then open /admin.");

        return self::SUCCESS;
    }
}
