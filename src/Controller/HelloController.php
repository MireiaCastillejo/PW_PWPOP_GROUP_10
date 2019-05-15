<?php

namespace SallePW\SlimApp\Controller;

use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use SallePW\SlimApp\Model\Product;

final class HelloController
{
    private const COOKIES_ADVICE = 'cookies_advice';

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

    public function __invoke(Request $request, Response $response,$num)
    {
        /*$messages = $this->container
            ->get('flash')
            ->getMessage('test');*/

        /* $adviceCookie = FigRequestCookies::get($request, self::COOKIES_ADVICE);

         $isWarned = $adviceCookie->getValue();

         if (!$isWarned) {
             $response = $this->setAdviceCookie($response);
         }

         $_SESSION['counter'] = isset($_SESSION['counter']) ?
             $_SESSION['counter'] + 1 : 1;*/

        // Always start this first
       // session_start();
        $repository = $this->container->get('product_repo');




        $products = $repository->get();
        if (!isset($_SESSION['user_id'])) {
            // Redirect them to the login page

            return $this->container->get('view')->render($response, 'index.twig',[
                'products' => $products,
            ]);

        }



        //Lo que le pasamos a la vista
        return $this->container->get('view')->render($response, 'loggeduser.twig', ['products' => $products,'sesion'=>$_SESSION['user_id']]

        //'messages' => $messages,
        );

    }

    private function setAdviceCookie(Response $response): Response
    {
        return FigResponseCookies::set(
            $response,
            SetCookie::create(self::COOKIES_ADVICE)
                ->withHttpOnly(true)
                ->withMaxAge(3600)
                ->withValue(1)
                ->withDomain('testslim.test')
                ->withPath('/')
        );
    }

    public function likeProduct(Request $request, Response $response, $id): Response
    {

        try {
            //Pasamos a entero la array
            $id = (int)$id['id'];

            $repository = $this->container->get('product_repo');
            $repository->favourite($id);


        } catch (\Exception $e) {

            $response->getBody()->write('Unexpected error: ' . $e->getMessage());

            $this->container->get('view')->render($response, 'error.twig', []);
            return $response->withStatus(500);
        }

        $this->__invoke($request, $response);
        return $response->withStatus(201);


    }
}
