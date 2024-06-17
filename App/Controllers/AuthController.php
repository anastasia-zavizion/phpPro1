<?php
namespace App\Controllers;
use App\Models\User;
use App\Controllers\Controller;
use App\Validators\Auth\AuthValidator;
use App\Validators\Auth\RegisterValidator;
use App\Enums\Http\Status;
use ReallySimpleJWT\Token;

class AuthController extends Controller{

    public function register(){
        $fields = requestBody();
        if (RegisterValidator::validate($fields)) {
            $user = User::create([
                ...$fields,
                'password' => password_hash($fields['password'], PASSWORD_BCRYPT)
            ]);
            return $this->response(Status::CREATED->value, $user->toArray());
        }
        return $this->response(Status::UNPROCESSABLE_ENTITY->value, $fields, RegisterValidator::getErrors());

    }

   public function login(){
       $fields = requestBody();
       if (AuthValidator::validate($fields)) {
           $user = User::findBy('email', $fields['email']);
           if (password_verify($fields['password'], $user->password)) {
               $token = $user->generateToken(time() + 3600);
               return $this->response(Status::OK->value, compact('token'));
           }
       }
       return $this->response(Status::UNPROCESSABLE_ENTITY->value,errors:RegisterValidator::getErrors());
    }

}