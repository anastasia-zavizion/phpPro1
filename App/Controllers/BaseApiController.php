<?php
namespace Controllers;

class BaseApiController extends Controller{
    public function before(string $action,array $params):bool{
        return true;
    }
}