<?php
namespace App\Controllers;
use App\Controllers\Controller;
use App\Models\User;
use ReallySimpleJWT\Token;

class BaseApiController extends Controller{
    public function before(string $action,array $params):bool{
        $token = getAuthToken();
        $user = User::find(authId());
        if(!Token::validate($token, $user->password)){
            throw new Exception('Token is invalid', 422);
        }
        return true;
    }
}