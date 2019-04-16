<?php

namespace SallePW\SlimApp\Controller;


use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class ProfileController{


    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $this->container->get('view')->render($response, 'profile.twig',[]);
    }
}
