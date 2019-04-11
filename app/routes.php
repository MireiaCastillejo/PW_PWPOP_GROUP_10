<?php
use SallePW\SlimApp\Controller\HelloController;
use SallePW\SlimApp\Controller\Middleware\TestMiddleware;
use SallePW\SlimApp\Controller\Middleware\SessionMiddleware;
//use SallePW\SlimApp\Controller\FlashController;



//UNA RUTA POR CONTROLADOR
//$app
  //  ->get('/hello/{name}', 'SallePW\SlimApp\Controller\HelloController:helloAction')
    //->add('SallePW\SlimApp\Controller\Middleware\TestMiddleware');
$app
    ->get('/', HelloController::class)
    ->add(TestMiddleware::class);


$app->add(SessionMiddleware::class);

//$app->get('/flash', FlashController::class);