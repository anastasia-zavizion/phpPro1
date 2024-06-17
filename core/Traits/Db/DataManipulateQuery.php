<?php
namespace Core\Traits\Db;

trait DataManipulateQuery{

    static public function create(array $fields): null|static{
        $params = static::prepareQueryParams($fields);
        $query = db()->prepare("INSERT INTO ".static::$tableName." ($params[keys]) VALUES($params[placeholders])");
        if(!$query->execute($fields)){
            return null;
        }
        return static::find(static::getLastId());
    }

    static protected function prepareQueryParams(array $fields):array{
        $keys = array_keys($fields);
        $placeholders = array_map(fn($key) => ":$key", $keys);
        return  [
            'keys'=> implode(', ', $keys),
            'placeholders'=> implode(', ', $placeholders),
        ];
    }

    static public function getLastId():int{
        return db()->lastInsertId();
    }

}