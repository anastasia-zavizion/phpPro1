<?php
namespace App\Controllers\V1;

use App\Enums\Http\Status;
use App\Controllers\BaseApiController;
use App\Models\Lead;
use App\Models\Task;
use  App\Enums\Db\Operator;
use  App\Enums\Db\Order;
use  App\Validators\Leads\LeadValidator;
use splitbrain\phpcli\Exception;

class LeadsController extends BaseApiController
{
    protected Lead $lead;

    public function before(string $action, array $params): bool
    {
        $result = parent::before($action, $params);
        if (in_array($action, ['update', 'delete'])){
            if ($result) {
                $this->lead = Lead::find($params['id']);
                if (!$this->lead) {
                    throw new Exception('Not found', Status::NOT_FOUND->value);
                }
                if (!$this->lead || is_null($this->lead) || $this->lead->user_id !== authId()) {
                    throw new Exception('Forbidden for you', Status::FORBIDDEN->value);
             }
            }
        }
        return $result;
    }

    public function index()
    {
        return $this->response(Status::OK->value, ['method' => 'index', 'data' => ['leads' => Lead::select()->where('user_id', Operator::EQUAL, authId())->get()]]);
    }

    public function show(int $id)
    {
        return $this->response(Status::OK->value, ['method' => 'show', Lead::find($id)->toArray()]);
    }

    public function store()
    {
        $fields = requestBody();
        if (LeadValidator::validate($fields) && $this->lead = Lead::create([...$fields, 'user_id' => authId()])) {
            return $this->response(Status::CREATED->value, ['data' => ['lead' => $this->lead->toArray()]]);
        }
        return $this->response(Status::UNPROCESSABLE_ENTITY->value, $fields, LeadValidator::getErrors());
    }

    public function update(int $id)
    {
        $fields = requestBody();
        if (LeadValidator::validate($fields, true) && $this->lead->update($fields)) {
            return $this->response(Status::OK->value, ['data' => ['lead' => Lead::find($id)->toArray()]]);
        }
        return $this->response(Status::UNPROCESSABLE_ENTITY->value, $fields, LeadValidator::getErrors());
    }

    public function delete(int $id)
    {
        $result = Lead::destroy($id);
        if (!$result) {
            return $this->response(Status::OK->value, ['errors' => ['message' => 'Cant delete resource']]);
       }
        return $this->response(Status::OK->value, ['data' => ['message' => 'Deleted successfully']]);
    }
}