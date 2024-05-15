<?php

class Color
{
    private const MIN_COLOR_VALUE = 0;
    private const MAX_COLOR_VALUE = 255;

    public function __construct(private int $red,private int $green,private int $blue)
    {
        $this->setRed($red);
        $this->setGreen($green);
        $this->setBlue($blue);
    }

    private function validateColorComponent($value)
    {
        if ($value < self::MIN_COLOR_VALUE   || $value > self::MAX_COLOR_VALUE) {
            throw new \InvalidArgumentException('Color component value must be between '.self::MIN_COLOR_VALUE.' and '.self::MAX_COLOR_VALUE.'.');
        }
    }

    public function getRed()
    {
        return $this->red;
    }

    public function getGreen()
    {
        return $this->green;
    }

    public function getBlue()
    {
        return $this->blue;
    }

    public function setRed($value)
    {
        $this->validateColorComponent($value);
        $this->red = $value;
    }

    public function setGreen($value)
    {
        $this->validateColorComponent($value);
        $this->green = $value;
    }

    public function setBlue($value)
    {
        $this->validateColorComponent($value);
        $this->blue = $value;
    }

    public function equals(Color $obj)
    {
        return $this->red === $obj->red &&
            $this->green === $obj->green &&
            $this->blue === $obj->blue;
    }

    public static function random(){
        return new self(rand(0,255),rand(0,255),rand(0,255));
    }

    public function mix(Color $obj){
        $red = ($this->red + $obj->red) / 2;
        $green = ($this->green + $obj->green) / 2;
        $blue = ($this->blue + $obj->blue) / 2;
        return new self($red,$green,$blue);
    }


}