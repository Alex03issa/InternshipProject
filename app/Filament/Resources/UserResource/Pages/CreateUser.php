<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Support\EmailEncryption;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Store the e-mail the same way sign-up does (encrypted + hashed_email),
     * otherwise the new user could never sign in.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $hashedEmail = EmailEncryption::hash($data['email']);

        if (User::where('hashed_email', $hashedEmail)->exists()) {
            throw ValidationException::withMessages([
                'data.email' => 'A user with this e-mail already exists.',
            ]);
        }

        return array_merge($data, EmailEncryption::attributes($data['email']), [
            'is_verified' => true,
            'provider' => $data['provider'] ?? 'sidetoside',
        ]);
    }
}
