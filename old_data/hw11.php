<?php
require_once __DIR__.'/vendor/autoload.php';

use Overload\ContactBuilder;
use Overload\ContactBook;

$contactBuilder = new ContactBuilder();
$contact = $contactBuilder->name("Anastasia")->surname("Zavizion")->phone("1234567")->email("a.zavizion.a@gmail.com")->build();
echo $contact;

$contactBook = new ContactBook();
$contactBook->setBuilder($contactBuilder);
$adminContact = $contactBook->adminContact();

echo $adminContact;