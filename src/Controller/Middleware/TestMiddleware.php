<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-04-04
 * Time: 20:37
 */

namespace SallePW\SlimApp\Controller\Middleware;
use Slim\Flash\Messages;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TestMiddleware
{
    public function __invoke(
        Request $request,
        Response $response,
        Callable $next
    )
    {
        //$response->getBody()->write('Before');

        /** @var Response $response */
        $response = $next($request, $response);

        //$response->getBody()->write('After');

        return $response;


    }

}