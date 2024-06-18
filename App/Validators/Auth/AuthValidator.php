<?php
namespace App\Validators\Auth;

class AuthValidator extends Base
{
    const DEFAULT_MESSAGE = 'Email or password is incorrect';

    static protected array $errors = [
        'email' => self::DEFAULT_MESSAGE,
        'password' => self::DEFAULT_MESSAGE
    ];

    static protected array $skip  = ['username'];

    public static function validate(array $fields = []): bool
    {
        $isValid = parent::validate($fields);
        $isEmailValid = static::checkEmailOnExists($fields['email'] ?? '', false, self::DEFAULT_MESSAGE);
        return $isValid && $isEmailValid;
    }

}