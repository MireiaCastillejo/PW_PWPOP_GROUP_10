<?php

use SallePW\SlimApp\Controller\HelloController;
use SallePW\SlimApp\Controller\Middleware\TestMiddleware;
use SallePW\SlimApp\Controller\Middleware\SessionMiddleware;
use SallePW\SlimApp\Controller\ProfileController;
use SallePW\SlimApp\Controller\RegController;
use SallePW\SlimApp\Controller\UserController;
use SallePW\SlimApp\Controller\ProductController;
use SallePW\SlimApp\Controller\LogController;
use SallePW\SlimApp\Controller\FavouriteController;
use SallePW\SlimApp\Controller\ProductReviewController;
use SallePW\SlimApp\Model\Email;


$app->add(SessionMiddleware::class);
//UNA RUTA POR CONTROLADOR
//La pagina principal
$app->get('/', HelloController::class);

$app->get('/logout', SessionMiddleware::class.':terminate');

$app->post('/{id:\d+}', HelloController::class . ':likeProduct')
    ->setName("updateproduct");

$app->post('/buy{id:\d+}', HelloController::class .':buyProduct')
    ->setName("buyProduct");

$app->post('/', HelloController::class . ':searchProduct')
    ->setName('search-info');
//La pagina de registro
$app->get('/register', RegController::class);


//La pagina de perfil
$app->get('/profile', ProfileController::class);

//UPLOAD PRODUCT
$app->get('/uploadproduct', ProductController::class);


$app->post('/uploadproduct', ProductController::class . ':uploadAction')
    ->setName("upload");

//REGISTER
$app->post('/register', RegController::class . ':regAction')
    ->setName('register');
//VERIFY

$app->get('/verify', RegController::class . ':verifyUser');

//RESEND EMAIL
$app->get('/resend', Email::class . ':reSendEmail');

//RESEND EMAIL
$app
    ->post('/emailToOwner{id:\d+}', Email::class . ':sendEmailToOwner');

//DELETE
$app->post('/update', UserController::class . ':put')
    ->setName('update');

//$app->get('/profile', ProfileController::class);

$app->get('/fetch', ProfileController::class . ':getUserData');

$app->post('/profile', ProfileController::class . ':updateInfo')
    ->setName('update-info');

//PRODUCTOS
$app->get('/myproducts', ProductController::class . ':myprod');

$app->get('/product_review', ProductReviewController::class);

$app->get('/product_update{id:/d+}', ProductReviewController::class);
$app->post('/product_update{array}', ProductReviewController::class . ':updateProduct');

$app->get('/product_review{id:\d+}', ProductReviewController::class. ':getProductData');
$app->get('/product_review_buyer{id:\d+}', ProductReviewController::class. ':getProductReview');


//FAVORITOS
$app->get('/favourite', FavouriteController::class);


//LOGIN
$app->get('/login', LogController::class);
    //->add(LoginMiddleware::class);

$app->post('/login', LogController::class . ':logAction')
    ->setName('login');


//->get('/product_review', ProductReviewController::class);

//$app->get('/productData', ProductController::class . 'myProd');

//$app->add(SessionMiddleware::class);

