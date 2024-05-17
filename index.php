<?php
require_once __DIR__.'/vendor/autoload.php';

//hw4
use Overload\User;
try {
    $user = new User('Test name',30,'testmail@gmail.com');
    $user->getAll();
    $user->setName('New name');
}catch (Throwable $e) {
    echo $e->errorMessage();
}

/*//hw3
require_once 'Color.php';
require_once 'helpers.php';

$color = new Color(250, 250, 250);
$colorSame = new Color(250, 250, 250);
$mixedColor = $color->mix(new Color(100, 100, 100));
show($mixedColor->getRed());
show($mixedColor->getGreen());
show($mixedColor->getBlue());

show($color->equals($mixedColor)); //false
show($color->equals($colorSame)); //true

$randonRgb = Color::random();
show($randonRgb->getRed());
show($randonRgb->getGreen());
show($randonRgb->getBlue());*/