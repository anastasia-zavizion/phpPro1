<?php
namespace App\Validators\Tasks;
use App\Validators\BaseValidation;
use App\Models\Lead;
use  App\Enums\Db\Operator;

class TaskValidator extends BaseValidation
{
    static protected array $errors = [
        'content' => 'Can have a-z and - symbol.Minimum 2 symbols',
        'title' => 'Can have a-z and - symbol.Minimum 2 symbols',
    ];

    static protected array $rules = [];

    public function __construct()
    {
        static::$rules = [
            'title' => $this->simpleString(),
            'content' => $this->simpleString(),
        ];
    }

    public static function validate(array $fields = [], bool $update = false): bool
    {
        $isValid = parent::validate($fields);
        $isLeadValid = $update ? false  : static::checkLead($fields['lead_id'], $update);
        return $isValid && $isLeadValid;
    }

    static public function checkLead(int $leadId): bool
    {
        $result = (bool) Lead::where('id', Operator::EQUAL,$leadId)->and('user_id', Operator::EQUAL, authId())->get();
        if (!$result) {
            static::setError('lead_id', 'Not correct lead');
        }
        return $result;
    }

}