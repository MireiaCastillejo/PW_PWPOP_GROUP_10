<?php

namespace SallePW\SlimApp\Controller\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class SessionMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        //SIEMPRE PASA POR AQUI PRIMERO

        //Iniciamos sesion





        return $next($request, $response);
    }


}


