<?php

namespace Core\Traits\Db;

trait OrderQuery
{
    public function orderBy($column, $order = Order::DESC):static{
        $this->require(['select'], "Order BY");
        $this->prevent(['order'],  "Order BY");
        $obj = in_array('select', $this->commands) ? $this : static::select();
        $this->commands[] = 'order';
        static::$query .=" ORDER BY $column $order->value";
        return $obj;
    }

    public function latest():static{
        return $this->orderBy('id',Order::DESC);
    }

    public function oldest():static{
        return $this->orderBy('id',Order::ASC);
    }

}