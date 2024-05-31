<?php

interface Format{
    public function format($string);
}

interface Delivery{
    public function deliver($formattedString);
}

class RawFormat implements Format{
    public function format($string){
        return $string;
    }
}

class DateFormat implements Format{
    public function format($string){
        return date('Y-m-d H:i:s') .' '.$string;
    }
}

class DateAndDetailsFormat implements Format{
    public function format($string){
        return date('Y-m-d H:i:s') .' '.$string . ' - With some details';
    }
}

class EmailDelivery implements Delivery{
    public function deliver($format){
        echo "Вывод формата ({$format}) по имейл<br>";
    }
}

class SmsDelivery implements Delivery{
    public function deliver($format){
        echo "Вывод формата ({$format}) в смс<br>";
    }
}

class ConsoleDelivery implements Delivery{
    public function deliver($format){
        echo "Вывод формата ({$format}) в консоль<br>";
    }
}

class Logger
{
    public function __construct(private Format $format, private Delivery $delivery)
    {

    }

    public function log($string)
    {
        $this->delivery->deliver($this->format->format($string));
    }
}

$rawFormat = new RawFormat();
$smsDelivery = new SmsDelivery();

$logger = new Logger($rawFormat, $smsDelivery);
$logger->log('Emergency error! Please fix me!');

$dateFormat = new DateFormat();
$emailDelivery = new EmailDelivery();

$logger = new Logger($dateFormat, $emailDelivery);
$logger->log('Emergency error! Please fix me!');