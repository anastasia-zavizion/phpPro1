<?php
interface Bird
{
    public function fly();
}

interface Animal
{
    public function eat();
}

class Swallow implements Animal,Bird
{
    public function eat() {}
    public function fly() {}
}

class Ostrich implements Animal
{
    public function eat() {}
}