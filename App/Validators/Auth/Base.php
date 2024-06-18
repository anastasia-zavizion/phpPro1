<?php
namespace App\Validators\Auth;

use App\Models\User;
use App\Validators\BaseValidation;

abstract class Base extends BaseValidation
{
    static protected array $rules = [];

    public function __construct()
    {
        static::$rules = [
            'email' => $this->email(),
            'password' => $this->password(),
            'username' => $this->username(),
        ];
    }

    static public function checkEmailOnExists(string $email, bool $eqError = true, string $message = 'Email already exists'): bool
    {
        $result = (bool) User::findBy('email', $email);
        if ($result === $eqError) {
            static::setError('email', $message);
        }
        return $result;
    }
}