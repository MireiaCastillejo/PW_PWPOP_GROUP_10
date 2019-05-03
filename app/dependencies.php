<?php

//use Slim\Flash\Messages;
use SallePW\SlimApp\Model\Database\PDORepository;
use SallePW\SlimApp\Model\Database\Database;
use Slim\Container;


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

$container['db'] = function (Container $c) {
    return Database::getInstance(
        $c['settings']['db']['username'],
        $c['settings']['db']['password'],
        $c['settings']['db']['host'],
        $c['settings']['db']['dbName']
    );
};

$container['user_repo'] = function (Container $c) {
    return new PDORepository($c->get('db'));
};


//$container['database'] = new \SallePW\Model\Services\PostUserService(new \SallePW\Model\MySQLUserRepository());

//$container['flash'] = function () {
//return new Messages();
//};

