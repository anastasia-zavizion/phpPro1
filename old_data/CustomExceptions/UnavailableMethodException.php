<?php
namespace CustomExceptions;

class UnavailableMethodException extends \Exception
{
    public function __construct(private array $additionalData = [])
    {
    }

    public function errorMessage() {
        $argStr = !empty($this->additionalData['arguments']) ? ' with arguments '.implode(', ', $this->additionalData['arguments']) : '';
        return "You are trying to call unavailable method '".$this->additionalData['name']."'".$argStr;
    }
}