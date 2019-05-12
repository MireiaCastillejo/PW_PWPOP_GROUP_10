<?php
use SallePW\SlimApp\Controller\HelloController;
use SallePW\SlimApp\Controller\Middleware\TestMiddleware;
use SallePW\SlimApp\Controller\Middleware\SessionMiddleware;
use SallePW\SlimApp\Controller\ProfileController;
use SallePW\SlimApp\Controller\RegController;
use SallePW\SlimApp\Controller\UserController;
use SallePW\SlimApp\Controller\ProductController;



//UNA RUTA POR CONTROLADOR
//La pagina principal
$app->get('/',HelloController::class);

//La pagina de registro
$app->get('/register', RegController::class);
// ->add(TestMiddleware::class)
//->add(SessionMiddleware::class);

//La pagina de perfil
//$app->get('/profile', ProfileController::class );
//->add(TestMiddleware::class);

$app->get('/uploadproduct',ProductController::class );

$app->post('/uploadproduct',ProductController::class . ':uploadAction')
    ->setName("upload");

//La accion del registro
$app->post('/register', RegController::class . ':regAction')
    ->setName('register');

//La accion del delete
$app->post('/update', UserController::class . ':put')
    ->setName('update');

$app->get('/profile', ProfileController::class);

$app->get('/fetch', ProfileController::class . ':getUserData')
    ->setName('getUserData');

$app->post('/profile', ProfileController::class . ':updateInfo')
    ->setName('update-info');