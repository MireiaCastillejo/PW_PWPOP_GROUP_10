<?php


namespace SallePW\SlimApp\Controller\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class LoginMiddleware
{
    public function __invoke(Request $request, Response $response, callable $nextMiddleware)
    {





        //$msg->warning('This is a warning message')
        //$response->getBody()->write($msg);

        /** @var Response $response */
        $response = $nextMiddleware($request, $response);

        $response->getBody()->write('Check your email!');

        return $response;
    }
}


/*namespace SallePW\SlimApp\Controller\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

MUESTRA EL MENSAJE DE REVISAR EL CORREO SI NO TE HAN VERIFICADO LA CUENTA
final class LoginMiddleware


    private $container;


    public function __construct(ContainerInterface $container)
{
    $this->container = $container;
}


    public function __invoke(Request $request, Response $response, callable $next)
    {
        if (!isset($_SESSION['user_id'])) {
            $this->container
                ->get('flash')
                ->addMessage('test', 'Flash message in action!');

            $msg->error('This is an error message', 'http://yoursite.com/another-page');
            return $response->withRedirect('/login', 301);
        }
    }
}*/



