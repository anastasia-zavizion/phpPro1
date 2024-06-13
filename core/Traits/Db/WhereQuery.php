<?php
namespace Core\Traits\Db;

trait  WhereQuery
{
    protected function where(string $column, $operator = Operator::EQUAL, mixed $value = ''):static{
        $this->prevent(['order', 'limit', 'having', 'group'], 'WHERE');
        $obj = in_array('select', $this->commands) ? $this : static::select();
        if(!is_null($value) && !is_bool($value) && !is_numeric($value) && !is_array($value)){
            $value = "'$value'";
        }
        if(is_null($value)){
            $value = 'NULL';
        }
        if(is_array($value)){
            $value = array_map(function ($item){
                if(is_string($item) && !is_null($item)){
                    $item="'$item'";
                }
                return $item;
            }, $value);

            $value = '('.implode(',',$value).')';
        }
        $whereStr = '';
        if(!in_array('where', $this->commands)){
            $whereStr .=" WHERE";
        }
        $whereStr .=" $column $operator->value $value";
        if(in_array('sum', $this->commands)){
            $groupByPos = stripos(static::$query, 'GROUP BY');
            if ($groupByPos !== false) {
                $query = substr_replace(static::$query, $whereStr . ' ', $groupByPos, 0);
                static::$query = $query;
            }
        }
        $this->commands[] = 'where';
        return $obj;
    }

    public function and(string $column, $operator = Operator::EQUAL, mixed $value = ''):static{
        $this->require(['where'], 'AND');
        static::$query .= ' AND';
        $this->commands[] = 'and';
        return $this->where($column, $operator, $value);
    }

    public function or(string $column, $operator = Operator::EQUAL, mixed $value = ''):static{
        $this->require(['where'], 'OR');
        static::$query .= ' OR';
        $this->commands[] = 'or';
        return $this->where($column, $operator, $value);
    }

}