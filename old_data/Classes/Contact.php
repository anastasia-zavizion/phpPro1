<?php
namespace Overload;

class Contact
{
    public string $name;
    public string $surname;
    public string $email;
    public string $phone;
    public string $address;

    public function __construct() {

    }

    public function getName(){
        return $this->name ?? null;
    }

    public function getSurname(){
        return $this->surname ?? null;
    }

    public function getEmail(){
        return $this->email ?? null;
    }

    public function getPhone(){
        return $this->phone ?? null;
    }

    public function getAddress(){
        return $this->address ?? null;
    }

    public function __toString(): string{
        $str ='';
        if(!empty($this->getName())){
            $str.='Name:'.$this->getName().'<br>';
        }
        if(!empty($this->getSurname())){
            $str.='Surname:'.$this->getSurname().'<br>';
        }
        if(!empty($this->getEmail())){
            $str.='Email:'.$this->getEmail().'<br>';
        }
        if(!empty($this->getPhone())){
            $str.='Phone:'.$this->getPhone().'<br>';
        }
        if(!empty($this->getAddress())){
            $str.='Address:'.$this->getAddress().'<br>';
        }
        return $str.'<br>';
    }
}