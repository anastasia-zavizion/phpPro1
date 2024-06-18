<?php
use App\Enums\Http\Status;
use Core\DB;
use Dotenv\Dotenv;
use ReallySimpleJWT\Token;

function db(): PDO{
    return DB::connect();
}

function jsonResponse(int $code = 200, array $data = []): string
{
    header_remove();
    http_response_code($code);
    header("Cache-Control: no-transform,public,max-age:300,s-maxage=900");
    header("Content-Type: application/json");

    $statuses = [
        200 => '200 OK',
        201 => '201 Created',
        400 => '400 Bad Request',
        403 => '403 Forbidden',
        422 => '422 Unprocessable Entity',
        404 => '404 Not found',
        500 => '500 Internal Server Error',
    ];

    header("Status: " . $statuses[$code]);

    return json_encode([
        'code' => $code,
        'status' => $statuses[$code],
        ...$data
    ]);
}

function loadEnv(){
    $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
    $dotenv->safeLoad();
}

function requestBody() : array{
    $data = [];
    $requestBody = file_get_contents("php://input");
    if(!empty($requestBody)){
        $data = json_decode($requestBody, true); //convert json to array
    }
    return $data;
}

function getAuthToken() : string{
    $headers = apache_request_headers();
    if(empty($headers['Authorization'])){
        throw new Exception('Request should contain  Auth token', 422);
    }
     $token = str_replace('Bearer ', '', $headers['Authorization']);

    if(!Token::validateExpiration($token)){
        throw new Exception('Auth token is invalid', 422);
    }

    return $token;
}

function authId() : int{
    $token  = Token::getPayload(getAuthToken());
    if(empty($token['user_id'])){
        throw new Exception('Token is invalid', 422);
    }
    return $token['user_id'];
}