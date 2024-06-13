<?php
namespace App\Models;
use Core\Model;

class Task extends Model
{
    public int $id;
    public int|null $task_id;
    public int|null $lead_id;
    public string|null $title;
    public string|null $name;
    public string|null $content;
    public int|null $status_id;

    static protected string|null $tableName = 'tasks';
}