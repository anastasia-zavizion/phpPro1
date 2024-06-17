<?php
namespace Core;
use Core\Traits\Db\Queryable;
use Core\Traits\Db\ConstraintQuery;
use Core\Traits\Db\WhereQuery;
use Core\Traits\Db\OrderQuery;
use Core\Traits\Db\DataManipulateQuery;

abstract class Model
{
    use Queryable, ConstraintQuery, WhereQuery, OrderQuery, DataManipulateQuery;

    public int $id;

   public function toArray():array{
        //get only public props
        $data = [];
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        $vars = (array)$this;
        $varsKeys = array_keys($vars);

        foreach ($props as $prop){
            if(!in_array($prop->getName(), $varsKeys) || in_array($prop->getName(), ['commandas','tableName', 'lead_id', 'task_id'])){
                continue;
            }
            $data[$prop->getName()] = $vars[$prop->getName()];

        }
        return $data;
    }

}