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


    public function update(array $fields): static
    {
        $query = "UPDATE " . static::$tableName . " SET " . $this->updatePlaceholders(array_keys($fields)) . " WHERE id = :id";
        $query = db()->prepare($query);
        $fields['id'] = $this->id;
        $query->execute($fields);
        return static::find($this->id);
    }

    protected function updatePlaceholders(array $keys): string
    {
        $string = '';
        $lastKey = array_key_last($keys);
        foreach ($keys as $index => $key) {
            $string .= "$key = :$key" . ($index !== $lastKey ? ', ' : '');
        }
        return $string;
    }

    static public function destroy(int $id): bool
    {
        $query = db()->prepare("DELETE FROM " . static::$tableName . " WHERE id = :id");
        $query->bindParam('id', $id);
        return $query->execute();
    }

}