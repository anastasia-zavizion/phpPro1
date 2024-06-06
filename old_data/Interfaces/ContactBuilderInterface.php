<?php
namespace Interfaces;

interface ContactBuilderInterface{
    public function name($name);
    public function surname($surname);
    public function email($email);
    public function address($address);
    public function phone($phone);
    public function build();
}