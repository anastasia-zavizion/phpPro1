<?php
namespace Overload;
use Interfaces\ContactBuilderInterface;

class ContactBuilder implements ContactBuilderInterface{

    protected $object;

    public function __construct()
    {
        $this->reset();
    }

    private function reset(){
        $this->object = new Contact();
    }

    public function name($name){
        $this->object->name = $name;
        return $this;
    }

    public function surname($surname){
        $this->object->surname = $surname;
        return $this;
    }

    public function email($email){
        $this->object->email = $email;
        return $this;
    }

    public function address($address){
        $this->object->address = $address;
        return $this;
    }

    public function phone($phone){
        $this->object->phone = $phone;
        return $this;
    }

    public function build(){
        return $this->object;
    }
}