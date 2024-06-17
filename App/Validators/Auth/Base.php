<?php
namespace App\Validators\Auth;

use App\Models\User;
use App\Validators\BaseValidation;

abstract class Base extends BaseValidation
{
    static protected array $rules = [
        'email' => '/^[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i',
        'password' => '/[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]{8,}/',
        'username' => '/[a-zA-Z0-9.!#$%&\'*+\/\?^_`{|}~-]{3,}/',
    ];

    static public function checkEmailOnExists(string $email, bool $eqError = true, string $message = 'Email already exists'): bool
    {
        $result = (bool) User::findBy('email', $email);
        if ($result === $eqError) {
            static::setError('email', $message);
        }
        return $result;
    }
}