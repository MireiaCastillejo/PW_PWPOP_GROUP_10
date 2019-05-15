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

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
            $_SESSION['isreg'] = 0;

            echo '<script>console.log("INICIO SESION")</script>';
        }
        var_dump($_SESSION['isreg']);

        if($_SESSION['isreg']==1){
            $_SESSION['enabled'] =0;
            echo '<script>console.log("Ponemos enabled a 0")</script>';
        }



        //$_SESSION['enabled'] = 0;

        return $next($request, $response);
    }

    public function terminate()
    {
        session_start();
        session_destroy();
        header('Location: /');




    }

}


