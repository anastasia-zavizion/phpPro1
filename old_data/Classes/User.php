<?php
namespace Overload;
use CustomExceptions\UnavailableMethodException;

class User
{
    public function __construct(private string $name, private int $age, private string $email)
    {
    }

    private function setName($name){
        $this->name = $name;
    }

    private function setAge($age){
        $this->age = $age;

    }

    private function setEmail($email){
        $this->email = $email;
    }

    public function __call($name, $arguments) {
        throw new UnavailableMethodException(["name" => "$name", "arguments" => $arguments]);
    }

    public function getAll(){
        echo "Name:$this->name<br>Age:$this->age<br>Email:$this->email<br>";
    }

}