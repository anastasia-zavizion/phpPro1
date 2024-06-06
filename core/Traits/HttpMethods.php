<?php
namespace Core\Traits;
use App\Enums\Http\Method;

trait HttpMethods{

    static public function put(string $uri){
        return static::setUri($uri)->setMethod(Method::PUT);
    }

    static public function get(string $uri){
        return static::setUri($uri)->setMethod(Method::GET);
    }

    static public function post(string $uri){
        return static::setUri($uri)->setMethod(Method::POST);
    }
    static public function delete(string $uri){
        return static::setUri($uri)->setMethod(Method::DELETE);
    }

    protected function checkRequestMethod()
    {
        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        if ($requestMethod !== strtolower($this->params['method'])) {
            throw new \Exception("Method [$requestMethod] is not allowed for this route!", 405);
        }
        unset($this->params['method']);
    }

}