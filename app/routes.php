<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

//UNA RUTA POR CONTROLADOR
$app
    ->get('/hello/{name}', 'SallePW\SlimApp\Controller\HelloController:helloAction')
    ->add('SallePW\SlimApp\Controller\Middleware\TestMiddleware');
