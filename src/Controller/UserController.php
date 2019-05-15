<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-05-06
 * Time: 23:49
 */

namespace SallePW\SlimApp\Controller;

use DateTime;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use SallePW\SlimApp\Model\Database\PDORepository;
use SallePW\SlimApp\Model\User;

class UserController
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function put(Request $request, Response $response): Response
    {

        try {
            $data = $request->getParsedBody();
            //session_start();
            if (isset($_SESSION['user_id'])) {
                /** @var PDORepository $repository */
                $repository = $this->container->get('user_repo');
                var_dump($_SESSION['user_id']);
                // We should validate the information before creating the entity
                $repository->deleteAccount($_SESSION['user_id']);

                $repository->deleteProducts($_SESSION['user_id']);
                session_destroy ( );
                //Redireccionamos a la pagina principal despues de eliminar la cuenta
                header('Location: /');
                return $response->withStatus(200);
            }

        } catch (\Exception $e) {
            $response->getBody()->write('Unexpected error: ' . $e->getMessage());
            return $response->withStatus(500);
        }
    }
}