<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * The admin account is read from ADMIN_EMAIL / ADMIN_PASSWORD in .env
     * (no defaults). If they are not set, no admin is created; run
     * `php artisan admin:create` instead.
     */
    public function run(): void
    {
        $email = config('app.admin.email');
        $password = config('app.admin.password');

        if (!$email || !$password) {
            $this->command?->warn('ADMIN_EMAIL / ADMIN_PASSWORD not set: skipping admin user. Run `php artisan admin:create`.');

            return;
        }

        Artisan::call('admin:create', [
            '--email' => $email,
            '--password' => $password,
            '--name' => config('app.admin.name'),
            '--username' => config('app.admin.username'),
        ]);

        $this->command?->info(trim(Artisan::output()));
    }
}
