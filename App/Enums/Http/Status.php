<?php
namespace App\Enums\Http;

enum Status: int
{
case OK = 200;
case CREATED = 201;
case BAD_REQUEST = 400;
case NOT_FOUND = 404;
case FORBIDDEN = 403;
case METHOD_NOT_ALLOWED = 405;
case UNPROCESSABLE_ENTITY = 422;
case INTERNAL_SERVER_ERROR = 500;
}