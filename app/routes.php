<?php
use SallePW\SlimApp\Controller\HelloController;
use SallePW\SlimApp\Controller\Middleware\TestMiddleware;
use SallePW\SlimApp\Controller\Middleware\SessionMiddleware;
use SallePW\SlimApp\Controller\ProfileController;
use SallePW\SlimApp\Controller\RegController;



//UNA RUTA POR CONTROLADOR

$app->get('/',HelloController::class);
    //->add('SallePW\SlimApp\Controller\Middleware\TestMiddleware');

$app->get('/register', RegController::class);
   // ->add(TestMiddleware::class)
    //->add(SessionMiddleware::class);

$app->get('/profile', ProfileController::class);
    //->add(TestMiddleware::class);


$app
    ->post('/register', RegController::class . ':regAction')
    ->setName('register');


