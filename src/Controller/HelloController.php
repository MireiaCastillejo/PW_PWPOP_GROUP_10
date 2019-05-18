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

    public function __invoke(Request $request, Response $response)
    {

        $repository = $this->container->get('product_repo');

        $products = $repository->get();


            if (!isset($_SESSION['user_id'])) {
                // Redirect them to the login page

                return $this->container->get('view')->render($response, 'index.twig', [
                    'products' => $products,
                ]);

        }
        for ($i = 0; $i <sizeof($products); $i++) {
            $id=(int)$_SESSION['user_id'];
            $fav = $repository->mirafav($id,$products[$i]['id']);

            $favs[$i]=$fav;
        }

        $repository_u = $this->container->get('user_repo');
        $enabled = $repository_u->checkEnabled();

        //Lo que le pasamos a la vista
        return $this->container->get('view')->render($response, 'loggeduser.twig',
            ['products' => $products,
                'sesion'=>$_SESSION['user_id'],
                'enabled' => $enabled,
                'favs'=> $favs]

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
            $repository->fav($_SESSION['user_id'],$id);



        } catch (\Exception $e) {

            $response->getBody()->write('Unexpected error: ' . $e->getMessage());

            $this->container->get('view')->render($response, 'error.twig', []);
            return $response->withStatus(400);
        }

        $this->__invoke($request, $response);
        header('Location:/');
        return $response->withStatus(201);


    }

    public function buyProduct(Request $request, Response $response, $ide):Response{
        try {
            //Pasamos a entero la array
            $id = (int)$ide['id'];

            $repository = $this->container->get('product_repo');

            $repository->buy($id);


        } catch (\Exception $e) {

            $response->getBody()->write('Unexpected error: ' . $e->getMessage());

            $this->container->get('view')->render($response, 'error.twig', []);
            return $response->withStatus(400);
        }



        header('Location: /');
        $this->__invoke($request, $response);

        $email = $this->container->get('email');
        $response = $email->sendEmailToOwner($request, $response, $ide);

        return $response->withStatus(201);
    }

    public function searchProduct(Request $request, Response $response):Response{
        try {


            $repository = $this->container->get('product_repo');


            $title=$_POST['TitleInput'];
            $cat=$_POST['category'];
            $pricemin=floatval($_POST['pricemin']);
            $pricemax=floatval($_POST['pricemax']);

                $result=$repository->searchProduct($title, $cat,$pricemin,$pricemax);
            if (!isset($_SESSION['user_id'])) {
                // Redirect them to the login page

                return $this->container->get('view')->render($response, 'index.twig', [
                    'products' => $result,
                ]);

            }
            //Lo que le pasamos a la vista
            return $this->container->get('view')->render($response, 'loggeduser.twig',
                ['products' => $result, 'sesion' => $_SESSION['user_id']]
            //'messages' => $messages,
            );



        } catch (\Exception $e) {

            $response->getBody()->write('Unexpected error: ' . $e->getMessage());

            $this->container->get('view')->render($response, 'error.twig', []);
            return $response->withStatus(400);
        }

        //$this->__invoke($request, $response);
        return $response->withStatus(201);
    }
}
