<?php
namespace App\Validators;

abstract class BaseValidation
{
  static protected array $rules = [], $errors = [], $skip = [];

   static public function validate(array $fields) : bool{
        static::$errors = [];

        if(empty(static::$rules)){
            return true;
        }
       foreach ($fields as $key => $field) {
           if (in_array($key, static::$skip)) {
               continue;
           }
           if (!empty(static::$rules[$key]) && preg_match(static::$rules[$key], $field)) {
               unset(static::$errors[$key]);
           }
       }
      return empty(static::$errors);
    }

    static public function getErrors(): array
    {
        return static::$errors;
    }

    static public function setError(string $key, string $message): void
    {
        static::$errors[$key] = $message;
    }

}