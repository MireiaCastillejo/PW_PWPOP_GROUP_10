<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-04-04
 * Time: 20:15
 */

namespace SallePW\SlimApp\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


final class HelloController
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

    public function indexAction(Request $request, Response $response, array $args)
    {
        return $this->container->get('view')->render($response, 'index.twig', [
            'name' => $args['name'],
        ]);
    }
    public function helloAction(Request $request, Response $response, array $args)
    {

        return $this
            ->container
            ->get('view')
            ->render($response, 'index.twig', [
            'name' => $args['name'],
        ]);
    }


}