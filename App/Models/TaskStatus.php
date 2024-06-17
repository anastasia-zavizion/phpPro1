<?php
namespace App\Models;

use Core\Model;

class TaskStatus extends Model
{
    public int $id;
    public string|null $name;
   
    static protected string|null $tableName = 'tasks_statuses';
}