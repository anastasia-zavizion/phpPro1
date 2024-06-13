<?php
namespace Core\Traits\Db;
use PDO;
use  App\Enums\Db\Operator;
use  App\Enums\Db\Order;
use splitbrain\phpcli\Exception;

trait Queryable{

    static protected string|null $tableName = null;

    static protected string $query = '';
    private array $commands = [];

    static protected function resetQuery():void{
        static::$query = '';
    }

    static public function select(array $column = ['*']): static
    {
        static::resetQuery();
        static::$query = 'SELECT ' . implode(', ', $column) . ' FROM ' . static::$tableName;
        $obj = new static;
        $obj->commands[] = 'select';
        return $obj;
    }

    static public function getAll(array $column = ['*']):array{
        return static::select($column)->get();
    }

    static public function find(int $id):static|false{
        static::resetQuery();
        $query = db()->prepare('SELECT * FROM '.static::$tableName.' WHERE id=:id'); //todo for id
        $query->bindParam('id',$id);
        $query->execute();
        return $query->fetchObject(static::class);
    }

    static public function findOrFail(int $id):static|false{
        $result = static::find($id);
        if(!$result){
            throw new Exception(static::class." cant find record with id $id");
        }
        return $result;
    }

    static public function findBy(string $column, mixed $value):static|false{
        $query = db()->prepare('SELECT * FROM '.static::$tableName." WHERE $column=:$column"); //todo for id
        $query->bindParam($column,$value);
        $query->execute();
        return $query->fetchObject(static::class);
    }

     public function join(string $table, string $first,  $second = null, $type = 'INNER'):static|false{
         $this->require(['select'], "JOIN");
         $this->prevent(['order', 'group', 'where', 'having', 'sum'], "JOIN");
         $obj = in_array('select', $this->commands) ? $this : static::select();
         $this->commands[] = 'join';
         static::$query .=" $type JOIN  $table ON $first=$second ";
         return $obj;
    }

     public static function sum(string $column , string $groupBy){
         static::resetQuery();
         static::$query = 'SELECT ' .$groupBy .", SUM($column) AS $column FROM " . static::$tableName;
         $obj = new static;
         $obj->commands[] = 'select';
         $obj->commands[] = 'sum';
         if($groupBy){
             $obj->groupBy($groupBy);
         }
         return $obj;
    }

     public function groupBy($column){
         $this->require(['select','sum'], "GROUP BY");
         $obj = in_array('select', $this->commands) ? $this : static::select();
         static::$query .=" GROUP BY $column";
         return $obj;
     }

    public function get(): array
    {
        return db()->query(static::$query)->fetchAll(PDO::FETCH_CLASS, static::class);
    }

    public static function __callStatic(string $name, array $arguments)
    {
        if(in_array($name, ['where', 'orderBy'])){
            return call_user_func_array([new static,$name], $arguments);
        }
        throw new \Exception('Static methid not allows', 422);
    }

    public function __call(string $name, array $arguments)
    {
        if (in_array($name, ['where'])) {
            return call_user_func_array([$this, $name], $arguments);
        }
        throw new Exception("Static method not allowed", 422);
    }

}