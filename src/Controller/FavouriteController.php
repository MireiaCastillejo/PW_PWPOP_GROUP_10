<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-05-10
 * Time: 16:07
 */

namespace SallePW\SlimApp\Controller;

use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class FavouriteController
{
    /** @var ContainerInterface */
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function __invoke(Request $request, Response $response, array $args)
    {

        $repository = $this->container->get('product_repo');

        $products = $repository->get();

        //Lo que le pasamos a la vista
        return $this->container->get('view')->render($response, 'favourite.twig', ['products' => $products]
        );
    }

}