<?php
namespace App\Models;
use Core\Model;

class LeadTask extends Model
{
    public int $id;
    public int|null $task_id;
    public int|null $lead_id;
    
    static protected string|null $tableName = 'leads_tasks';
}