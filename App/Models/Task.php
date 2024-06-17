<?php
namespace App\Models;
use Core\Model;
use  App\Enums\Db\Operator;

class Task extends Model
{
    public int $id;
    public int|null $task_id;
    public int|null $user_id;
    public int|null $lead_id;
    public string|null $title;
    public string|null $name;
    public string|null $content;
    public int|null $status_id;

    static protected string|null $tableName = 'tasks';

    public static function getTasksByLead($leadId){
        return Task::select(['tasks.id', 'tasks.title', 'tasks.content', 'leads.id as lead_id', 'leads.name'])->join('leads_tasks', 'tasks.id', 'leads_tasks.task_id')->join('leads', 'leads.id', 'leads_tasks.lead_id')->where('leads.id', Operator::EQUAL, $leadId)->get();
    }

    public function getTaskLead(){
        $query = db()->prepare('SELECT lead_id FROM leads_tasks WHERE task_id=:task_id');
        $query->bindParam('task_id',$this->id);
        $query->execute();
        return $query->fetchColumn();
    }

    public static function removeTaskLead($taskId){
        $query = db()->prepare('DELETE FROM leads_tasks WHERE task_id=:task_id');
        $query->bindParam('task_id',$taskId);
        return  $query->execute();
    }

}