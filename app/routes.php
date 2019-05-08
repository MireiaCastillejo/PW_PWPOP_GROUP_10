<?php
use SallePW\SlimApp\Controller\HelloController;
use SallePW\SlimApp\Controller\ProfileController;
use SallePW\SlimApp\Controller\RegController;
use SallePW\SlimApp\Controller\LogController;



//UNA RUTA POR CONTROLADOR

$app->get('/',HelloController::class);
    //->add('SallePW\SlimApp\Controller\Middleware\TestMiddleware');

$app->get('/register', RegController::class);
   // ->add(TestMiddleware::class)
    //->add(SessionMiddleware::class);

$app->get('/login', LogController::class);

$app->get('/profile', ProfileController::class);
    //->add(TestMiddleware::class);




$app
    ->post('/register', RegController::class . ':regAction')
    ->setName('register');

$app
    ->post('/login', LogController::class.':logAction')
    ->setName('login');

$app ->get('/verify',RegController::class . ':verifyUser');


