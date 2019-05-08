<?php
/**
 * Created by PhpStorm.
 * User: Judit
 * Date: 08/05/2019
 * Time: 14:47
 */

namespace SallePW\SlimApp\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LogController
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

    public function __invoke(Request $request, Response $response, array $args)
    {

        //Lo que le pasamos a la vista
        return $this->container->get('view')->render($response, 'login.twig');
    }
    public function logAction(Request $request, Response $response): Response
    {


        try {
            // This method decodes the received json
            $data = $request->getParsedBody();

            /** @var PDORepository $repository**/
            $repository = $this->container->get('user_repo');

            //Validamos los campos y guardamos los errores
            //$errors = $this->validate($data, $request);




            if(empty($errors)){
                //Como la seda

            }else{
                //Algo ha ido mal

                throw new \Exception('The validation went wrong');
            }




        } catch (\Exception $e) {

            //Si algo va mal al validar, mostramos la ventana de error

            //$response->getBody()->write('Unexpected error: ' . $e->getMessage());
            $this->container->get('view')->render($response, 'login.twig', [
                'errors' => $errors,
            ]);
            return $response->withStatus(500);
        }



        //Mostramos la vista del login
        $this->container->get('view')->render($response, 'index.twig');

        //location.assign( path_for('login') );

        return $response->withStatus(201);
    }

}