<?php
namespace App\Controllers\V1;
use App\Enums\Http\Status;
use App\Controllers\Controller;
use App\Models\Lead;
use App\Models\Task;
use  App\Enums\Db\Operator;
use  App\Enums\Db\Order;

class TasksController extends Controller{

    public function index(){
        return $this->response(Status::OK->value, ['method'=>'index', 'data'=>['tasks'=>Task::select(['tasks.id', 'tasks.title', 'tasks.content', 'leads.id as lead_id', 'leads.name'])->join('leads_tasks', 'tasks.id', 'leads_tasks.task_id')->join('leads', 'leads.id', 'leads_tasks.lead_id')->get()]]);
    }

    public function show(int $id){
        return $this->response(Status::OK->value, ['method'=>'show', Task::find($id)->toArray()]);
    }

    public function store(){
        //store logic
        return $this->response(Status::OK->value, ['method'=>'store', 'data'=>['task'=>[]]]);
    }

    public function update(int $id){
        //update logic
        return $this->response(Status::OK->value, ['method'=>'update', 'data'=>['task'=>[]]]);
    }

    public function delete(int $id){
        //delete logic
        return $this->response(Status::OK->value, ['method'=>'delete', 'data'=>[]]);
    }
}