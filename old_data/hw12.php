<?php
//interface
interface Car{
    public function model();
    public function price();
}

/*MAIN CLASSES */
class EconomCar implements Car{
    public function model(){
        return "Econom model";
    }
    public function price(){
        return "Econom price";
    }
}

class StandartCar implements Car{
    public function model(){
        return "Standart model";
    }
    public function price(){
        return "Standart price";
    }
}

class LuxCar implements Car{
    public function model(){
        return "Lux model";

    }
    public function price(){
        return "Lux price";
    }
}
/*MAIN CLASSES END */

/*CREATOR CLASS */
abstract class Taxi{
    abstract public function getCar():Car;

    public function getCarInfo(){
        $car = $this->getCar();
        echo "Model=". $car->model().'<br>';
        echo "Price=". $car->price().'<br>';
    }
}
/*END CREATOR CLASS */


/*CONCRETE CREATOR CLASSES*/

class EconomTaxi extends Taxi{

    public function getCar():Car{
        return new Economcar();
    }
}

class StandartTaxi extends Taxi{

    public function getCar():Car{
        return new StandartCar();
    }
}

class LuxTaxi extends Taxi{

    public function getCar():Car{
        return new LuxCar();
    }
}
/*END CONCRETE CREATOR CLASSES*/

/*CLIENT CODE*/
function callTaxi(Taxi $taxi){
    $taxi->getCarInfo();
}

$type = match ($_GET['type']){
  'econom'=>EconomTaxi::class,
  'standart'=>StandartTaxi::class,
  'lux'=>LuxTaxi::class,
   default=>null
};

if(!is_null($type) && class_exists($type)){
    callTaxi(new $type());
}
/*END CLIENT CODE*/