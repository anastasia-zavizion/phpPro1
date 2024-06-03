<?php
namespace Overload;
use Interfaces\ContactBuilderInterface;


class ContactBook
{
    private $builder;

    public function setBuilder(ContactBuilderInterface $builder){
        $this->builder = $builder;
    }

    public function adminContact(){
        $builder = $this->getBuilder();
        $builder->name("Admin name");
        $builder->surname("Admin surname");
        $builder->address("Kharkiv");
        $builder->phone("1234567890");
        $builder->email("admin@gmail.com");
        return $builder->build();

    }

    public function getBuilder(){
        return $this->builder;
    }

}