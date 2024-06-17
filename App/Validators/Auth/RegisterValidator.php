<?php
namespace App\Validators\Auth;
use App\Models\User;

class RegisterValidator extends Base
{
    static protected array $errors = [
        'email' => 'Email is incorrect',
        'username' => 'Username is incorrect.Minimum length is 3 symbols',
        'password' => 'Password is incorrect. Minimum length is 8 symbols'
    ];

    static public function validate(array $fields = []): bool
    {
        $isValid = parent::validate($fields);
        $emailCheck = static::checkEmailOnExists($fields['email'] ?? '');
        $usernameCheck = static::checkUserNameOnExists($fields['username'] ?? '');
        return $isValid && !$emailCheck && !$usernameCheck;
    }

    static public function checkUserNameOnExists(string $username): bool
    {
        $result = (bool) User::findBy('username', $username);
        if ($result) {
            static::setError('username', 'Username already exists');
        }
        return $result;
    }
}