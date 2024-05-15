<?php
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
show($randonRgb->getBlue());