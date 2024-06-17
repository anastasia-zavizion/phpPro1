<?php
namespace App\Controllers\V1;
use App\Enums\Http\Status;
use App\Controllers\Controller;
use App\Models\Lead;
use App\Models\Task;
use  App\Enums\Db\Operator;
use  App\Enums\Db\Order;

class LeadsController extends Controller{

    public function index(){
        dd(Lead::select()->where('id',Operator::IN, [1,2,'3'])->get());
        return $this->response(Status::OK->value, ['method'=>'index', 'data'=>['leads'=>Lead::getAll()]]);
    }

    public function show(int $id){
     /*   dd(Lead::select(['name'])->get());
     dd(Lead::findOrFail('id',1));*/

        return $this->response(Status::OK->value, ['method'=>'show', Lead::find($id)->toArray()]);
    }

    public function store(){
        //store logic
        return $this->response(Status::OK->value, ['method'=>'store', 'data'=>['lead'=>[]]]);
    }

    public function update(int $id){
        //update logic
        return $this->response(Status::OK->value, ['method'=>'update', 'data'=>['lead'=>[]]]);
    }

    public function delete(int $id){
        //delete logic
        return $this->response(Status::OK->value, ['method'=>'delete', 'data'=>[]]);
    }
}