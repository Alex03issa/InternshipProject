<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use App\Support\EmailEncryption;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('view_users')
                ->label('View Users')
                ->url(UserResource::getUrl('index'))
                ->icon('heroicon-o-user-group'),
        ];
    }

    /**
     * Show the plain e-mail in the form instead of the encrypted blob.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['email'] = EmailEncryption::decrypt($this->record->email) ?? $this->record->email;

        return $data;
    }

    /**
     * Re-encrypt the e-mail on save so the user can still sign in.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $hashedEmail = EmailEncryption::hash($data['email']);

        if (User::where('hashed_email', $hashedEmail)->whereKeyNot($this->record->getKey())->exists()) {
            throw ValidationException::withMessages([
                'data.email' => 'A user with this e-mail already exists.',
            ]);
        }

        return array_merge($data, EmailEncryption::attributes($data['email']));
    }
}
