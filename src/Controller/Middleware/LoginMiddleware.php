<?php

namespace SallePW\SlimApp\Controller\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class LoginMiddleware
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        if (!isset($_SESSION['user_id'])) {
            return $response->withRedirect('/login', 301);
        }
    }
}
