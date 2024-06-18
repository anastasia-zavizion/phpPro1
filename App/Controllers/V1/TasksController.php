<?php
namespace App\Controllers\V1;
use App\Enums\Http\Status;
use App\Controllers\BaseApiController;
use App\Models\Lead;
use App\Models\Task;
use App\Models\LeadTask;
use App\Validators\Tasks\TaskValidator;
use  App\Enums\Db\Order;
use  App\Enums\Db\Operator;
use splitbrain\phpcli\Exception;

class TasksController extends BaseApiController{

    protected Task $task;
    protected int $leadId;
    protected array $fields;

    public function before(string $action, array $params): bool
    {
        $result = parent::before($action, $params);
        $this->fields = requestBody();
        if ($result) {
            //lead_id is required
            if(!isset($this->fields['lead_id'])){
                throw new Exception('Parameter lead_id is missing', Status::UNPROCESSABLE_ENTITY->value);
        }
        $this->leadId = $this->fields['lead_id'];

        if (in_array($action, ['index'])){
            $lead = Lead::findOrFail($this->leadId);
            if($lead->user_id !== authId()){
                throw new Exception('This resource is forbidden for you', Status::FORBIDDEN->value);
          }
        }

        if (in_array($action, ['show', 'update'])){
            $this->task = Task::find($params['id']);
            if ($this->task->user_id !== authId() || ($this->task->getTaskLead() !== $this->leadId)) {
                throw new Exception('This resource is forbidden for you', Status::FORBIDDEN->value);
            }
        }


        }
        return $result;
    }

    public function index(){
        return $this->response(Status::OK->value, ['method'=>'index', 'data'=>['tasks'=>Task::getTasksByLead($this->fields['lead_id'])]]);
    }

    public function show(int $id){
        $task = Task::find($id);
        if (!$task) {
            return $this->response(Status::NOT_FOUND->value, errors: ['message' => 'Task not found']);
        }
        return $this->response(Status::OK->value, $task->toArray());
    }

    public function store(){
        $currentFields = $this->fields;
        unset($currentFields['lead_id']);
        if (TaskValidator::validate($this->fields) && $this->task = Task::create([...$currentFields, 'user_id' => authId()])) {
            //assign lead to task
            LeadTask::create(['lead_id'=>$this->leadId, 'task_id'=>$this->task->id]);
            return $this->response(Status::CREATED->value, ['data' => ['task' => $this->task->toArray()]]);
        }
        return $this->response(Status::UNPROCESSABLE_ENTITY->value, $this->fields, TaskValidator::getErrors());
    }

    public function update(int $id)
    {
        $currentFields = $this->fields;
        unset($currentFields['lead_id']);
        if (TaskValidator::validate($this->fields) && $this->task->update($currentFields)) {
            return $this->response(Status::OK->value, ['data' => ['task' => Task::find($id)->toArray()]]);
        }
        return $this->response(Status::UNPROCESSABLE_ENTITY->value, $fields, TaskValidator::getErrors());
    }

    public function delete(int $id)
    {
        Task::removeTaskLead($id);
        $result = Task::destroy($id);
        if (!$result) {
            return $this->response(Status::OK->value, ['errors' => ['message' => 'Cant delete resource']]);
       }
        return $this->response(Status::OK->value, ['data' => ['message' => 'Deleted successfully']]);
    }
}