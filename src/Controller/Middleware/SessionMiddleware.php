<?php

namespace SallePW\SlimApp\Controller\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\SetCookie;



final class SessionMiddleware
{



    public function __invoke(Request $request, Response $response, callable $next)
    {
        //SIEMPRE PASA POR AQUI PRIMERO


           if(isset($_COOKIE['user_id']) ){

                $_SESSION['user_id']= $_COOKIE['user_id'];

            }



        return $next($request, $response);
    }

    public function terminate()
    {

        if(isset($_COOKIE['user_id'])){

           //


            if (isset($_SERVER['HTTP_COOKIE']))
            {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie)
                {
                    $mainCookies = explode('=', $cookie);
                    $name = trim($mainCookies[0]);
                    setcookie($name, '', time()-1000);
                    setcookie($name, '', time()-1000, '/');
                }

                unset($_COOKIE['user_id']);
                //unset($_SESSION);
                unset($_SESSION['user_id']);


                session_destroy();

                header('Location: /');
            }



        }else{
            //unset($_SESSION);
            unset($_SESSION['user_id']);

            //NO REDIRECCIONA
            header('Location: /');
        }




    }

}


