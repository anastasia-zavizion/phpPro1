<?php
namespace App\Controllers;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

abstract class Controller{

    public function before(string $action,array $params):bool{
        return true;
    }

    public function after(string $action, array $params = []):void{
        $logger = new Logger("after");
        $stream_handler = new StreamHandler(BASE_DIR.'/logs/logs.txt');
        $logger->pushHandler($stream_handler);
        $logger->info("Controller:".$this::class.', Action:'.$action.', Params:'.implode(',',$params));
    }

    protected function response(int $code = 200, array $body = [], array $errors = [])
    {
        return compact('code', 'body', 'errors');
    }

}