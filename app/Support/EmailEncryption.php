<?php

namespace App\Support;

use Illuminate\Support\Facades\Crypt;

/**
 * The e-mail storage scheme used across the app:
 *
 *  users.hashed_email = HMAC-SHA256(email, HASH_SECRET)   (lookup index)
 *  users.email        = encrypt(json_encode([
 *                           'email' => encrypt(email),
 *                           'hash'  => hashed_email,
 *                       ]))
 *
 * The sign-up, login and Google controllers build these values inline; this
 * class gives the same result for code that creates users elsewhere (admin
 * command, admin panel, tests).
 */
class EmailEncryption
{
    public static function hash(string $email): string
    {
        return hash_hmac('sha256', $email, (string) config('app.hash_secret'));
    }

    public static function encrypt(string $email): string
    {
        return Crypt::encryptString(json_encode([
            'email' => Crypt::encryptString($email),
            'hash' => self::hash($email),
        ]));
    }

    /**
     * Returns the plain e-mail, or null when the value is not in the
     * encrypted format (e.g. a legacy plain-text row).
     */
    public static function decrypt(?string $stored): ?string
    {
        if (!$stored) {
            return null;
        }

        try {
            $data = json_decode(Crypt::decryptString($stored), true);

            return isset($data['email']) ? Crypt::decryptString($data['email']) : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Attributes to store on a User for the given plain e-mail.
     */
    public static function attributes(string $email): array
    {
        return [
            'email' => self::encrypt($email),
            'hashed_email' => self::hash($email),
        ];
    }
}
