<?php
namespace Core;
use PDO;
use function Monolog\getName;

class DB {
    protected static $instance = null;

    public static function connect() {
        if (self::$instance === null) {
          $options = [
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];
            $options = [];
            self::$instance = new PDO("mysql:host=".getenv('DB_HOST').";dbname=".getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'), $options);
        }
        return self::$instance;
    }

}