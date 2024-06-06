<?php
namespace App\Controllers\V1;
use App\Enums\Http\Status;
use App\Controllers\Controller;

class LeadsController extends Controller{

    public array $leads = [
        1=>[
            'name'=>'Lead1',
            'phone'=>'1111',
        ],
        2=>[
            'name'=>'Lead2',
            'phone'=>'2222',
        ],
        3=>[
            'name'=>'Lead3',
            'phone'=>'3333',
        ],
    ];

    public function index(){
        return $this->response(Status::OK->value, ['method'=>'index', 'data'=>['leads'=>$this->leads]]);
    }

    public function show(int $id){
        $lead = $this->leads[$id] ?? [];
        if($lead){
            return $this->response(Status::OK->value, ['method'=>'show', 'data'=>['lead'=>$lead]]);
        }else{
            return $this->response(Status::NOT_FOUND->value, ['method'=>'show', 'data'=>['lead'=>[]]]);
        }
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