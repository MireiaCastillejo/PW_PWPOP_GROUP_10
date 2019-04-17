<?php
/**
 * Created by PhpStorm.
 * User: Judit
 * Date: 13/04/2019
 * Time: 9:55
 */

namespace SallePW\SlimApp\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RegController
{
    /** @var ContainerInterface */
    private $container;

    /**
     * HelloController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {

        //Lo que le pasamos a la vista
        return $this->container->get('view')->render($response, 'registration.twig', [
            'name' => 'ouh mama',
        ]);
    }

}