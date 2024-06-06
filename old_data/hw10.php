<?php

interface Database{
    public function getData();
}

class Mysql implements Database
{
    public function getData()
    {
        return 'some data from database Mysql';
    }
}

class MongoDb implements Database
{
    public function getData()
    {
        return 'some data from database MongoDB';
    }
}

class Controller
{
    public function __construct(private Database $adapter)
    {
    }

    function getData()
    {
        echo $this->adapter->getData().'<br>';
    }
}

$mysql = new Mysql();
$controller = new Controller($mysql);
$controller->getData();

$mongoDb = new MongoDB();
$controller = new Controller($mongoDb);
$controller->getData();