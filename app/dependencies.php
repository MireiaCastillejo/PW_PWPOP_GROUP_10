<?php

//use Slim\Flash\Messages;

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../src/View/templates/',
        ['cache' => false,]);
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

// BASE DE DATOS

//$container['database'] = new \SallePW\Model\Services\PostUserService(new \SallePW\Model\MySQLUserRepository());

//$container['flash'] = function () {
//return new Messages();
//};

