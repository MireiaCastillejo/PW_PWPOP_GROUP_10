<?php

namespace SallePW\SlimApp\Controller;


use Psr\Container\ContainerInterface;
use SallePW\SlimApp\Model\Database\PDORepository;
use SallePW\SlimApp\Model\User;
use SallePW\SlimApp\Model\UserRepositoryInterface;
use SallePW\SlimApp\Controller\RegController;
use Slim\Http\Request;
use Slim\Http\Response;
use DateTime;

final class ProfileController
{


    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $this->container->get('view')->render($response, 'profile.twig', []);
    }

    /**
     * @param Request $request
     * @param Response $response
     */
    public function getInfo(Request $request, Response $response){

        try {
            $data = $request->getParsedBody();

            /** @var PDORepository $repository */
            $repository = $this->container->get('user_repo');

            //Fetch data from Database
            $repository->getInfo();

        }catch (\Exception $e) {
            $response->getBody()->write('Unexpected error: ' . $e->getMessage());
            return $response->withStatus(500);
        }
        return $response->withStatus(200);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function updateInfo(Request $request, Response $response):Response
    {

        try {

            echo '<script>console.log("updateINFOOO")</script>';

            // This method decodes the received json
            $data = $request->getParsedBody();

            //add username to data array
            $data['username']='user1';

            echo 'console.log('. json_encode( $data ) .')';
            echo '<script>console.log("updateINFO 2")</script>';


            /** @var PDORepository $repository * */
            $repository = $this->container->get('user_repo');

            //Validamos los campos y guardamos los errores
            $regController = new RegController($this->container);
            $errors = $regController->validate($data, $request, true);

            echo 'console.log errores('. json_encode( $errors ) .')';


            if(empty($data['birthdate'])){
                $aux= new DateTime("1000-01-01 00:00:00");
                $data['birthdate'] = $aux->format('Y-m-d H:i:s');
            }

            $uploadedFiles = $request->getUploadedFiles();
            $name = $uploadedFiles['profile']->getClientFilename();
            $fileInfo = pathinfo($name);

            $format = $fileInfo['extension'];


            if(empty($uploadedFiles['profile']->getClientFilename())){

                $data['profile'] = 'defaultProfile.png';
            }else{

                $data['profile'] = $data['username'].'.'.$format;
            }

            if(empty($errors)){
                $user = new User(
                    $data['name'],
                    $data['username'],
                    $data['email'],
                    $data['birthdate'],
                    $data['phonenumber'],
                    $data['password'],
                    $data['profile'],
                    1,
                    1,
                    new DateTime(),
                    new DateTime()
                );

                echo '<script>console.log("before update")</script>';


                $repository->update($user);

                echo '<script>console.log("update done")</script>';


            }else{
                //Algo ha ido mal

                throw new \Exception('The validation went wrong');
            }

        } catch (\Exception $e) {

            //Si hay fallo de validacion, ventana de error

            //$response->getBody()->write('Unexpected error: ' . $e->getMessage());
            $this->container->get('view')->render($response, 'profile.twig', [
                'errors' => $errors,
            ]);
            return $response->withStatus(500);
        }

        return $response->withRedirect('/profile',200);
    }

}