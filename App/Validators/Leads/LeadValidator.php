<?php
namespace App\Validators\Leads;
use App\Validators\BaseValidation;
use App\Models\Lead;
use  App\Enums\Db\Operator;

class LeadValidator extends BaseValidation
{
    static protected array $errors = [
        'email' => 'Email must have correct format',
        'name' => 'Can have a-z and - symbol.Minimum 2 symbols',
        'city' => 'Can have a-z and - symbol.Minimum 2 symbols',
        'phone' => 'Only digits and +. Minimum 5 symbols.',
        'address' => 'Can have a-z and - symbol.Minimum 2 symbols',
    ];

    static protected array $rules = [];

    public function __construct()
    {
        static::$rules = [
            'email' => $this->email(),
            'name' => $this->simpleString(),
            'city' => $this->simpleString(),
            'phone' => $this->phone(),
            'address' => $this->simpleString(),
        ];
    }

    public static function validate(array $fields = [], bool $update = false): bool
    {
        $isValid = parent::validate($fields);
        $isEmailValid = $update ? false  : static::checkEmailOnExists($fields['email'], $update);
        return $isValid && !$isEmailValid;
    }

    static public function checkEmailOnExists(string $email): bool
    {
        $result = (bool) Lead::where('email', Operator::EQUAL,$email)->and('user_id', Operator::EQUAL, authId())->get();
        if ($result) {
            static::setError('email', 'Lead with such email already exists');
        }
        return $result;
    }

}