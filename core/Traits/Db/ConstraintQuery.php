<?php
namespace Core\Traits\Db;

use splitbrain\phpcli\Exception;

trait ConstraintQuery{

    private function prevent(array $preventMethods, $command = ''){
        foreach ($preventMethods as $method){
            if(in_array($method, $this->commands)){
                throw new Exception(static::class." $command cannot be used after ".implode(',',$preventMethods));
            }
        }
    }

    private function require(array $requiredMethods, $command = ''){
        $found = array_intersect($requiredMethods, $this->commands);
        if (empty($found)) {
            throw new Exception(static::class." $command cannot be before ".implode(',', $requiredMethods));
        }
    }


}