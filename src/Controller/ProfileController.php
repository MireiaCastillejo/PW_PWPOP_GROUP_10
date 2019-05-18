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
        //session_start();
        $repository_u = $this->container->get('user_repo');
        $enabled = $repository_u->checkEnabled();

        if(isset($_SESSION['upd_ok'])){
            $upd_ok = $_SESSION['upd_ok'];
        }else{
            $upd_ok = 0;
        }


       // $this->container->get('view')->render($response, 'profile.twig', ['sesion'=>$_SESSION['user_id'], 'enabled' => $enabled]);

       // session_start();
        if ( isset( $_SESSION['user_id'] ) ) {
            $this->container->get('view')->render($response, 'profile.twig', ['sesion' => $_SESSION['user_id'],'upd_ok'=>$upd_ok]);
        }else{
            $error[]="ERROR 403 NO PUEDE ACCEDER SIN HACER LOGIN";
            $this->container->get('view')->render($response, 'error.twig', ['errors' => $error]);
            return $response->withStatus(403);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getUserData(Request $request, Response $response)
    {


        try {

            if ( isset( $_SESSION['user_id'] ) ) {

                /** @var PDORepository $repository */
                $repository = $this->container->get('user_repo');
                $id=(int)$_SESSION['user_id'];
                $data = $repository->getData($id);

                if (!isset($data['username'])) {

                    $response = $response
                        ->withStatus(404)
                        ->write(json_encode(["message" => "oof", "res" => $data]));

                } else {
                    $response = $response
                        ->withStatus(200)
                        ->write(json_encode(["message" => "correcto", "res" => $data]));

                }
            }
        } catch (\Exception $e) {
            $response = $response
                ->withStatus(500)
                ->write(json_encode(["message"=>"nope", "res"=>$e]));

        }
        return $response;
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
            //session_start();

            if ( isset( $_SESSION['user_id'] ) ) {

                // This method decodes the received json
                $data = $request->getParsedBody();

                $id=(int)$_SESSION['user_id'];

                //add user id to data array
                $data['user-id']=$id;

                /** @var PDORepository $repository * */
                $repository = $this->container->get('user_repo');
                $currentUser = $repository->getData($_SESSION['user_id']);

                $data['username'] = $currentUser['username'];
                $data['enabled'] = $currentUser['enabled'];

                //Rellenar los campos vacíos
                if($data['name'] === ''){
                    $data['name'] = $currentUser['name'];
                }else{
                    if (!ctype_alnum($data['name'])){
                        $errors['name'] = 'The name must be alphanumeric.';
                    }
                }

                if($data['email'] === ''){
                    $data['email'] = $currentUser['email'];
                }else{
                    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                        $errors['email'] = 'The email is not valid.';
                    }
                }

                if($data['birthdate'] === ''){
                    $b = explode(" ", $currentUser['birthdate']);
                    $data['birthdate'] = $b[0];
                }else {

                    $dateExploded = explode("-", $data['birthdate']);
                    $day = $dateExploded[2];
                    $month = $dateExploded[1];
                    $year = $dateExploded[0];

                    if (!checkdate($month, $day, $year)) {
                        $errors['birthdate'] = 'The birthdate is not valid.';
                    }
                }

                if($data['phonenumber'] === ''){
                    $data['phonenumber'] = $currentUser['phonenumber'];
                }else{
                    if (!preg_match( '/[0-9]{3}[ ][0-9]{3}[ ][0-9]{3}/', $data['phonenumber'])) {
                        $errors['phonenumber'] = 'The phone number must follow the format xxx xxx xxx, only numbers.';
                    }
                }

                if($data['enabled'] === ''){
                    $data['enabled'] = $currentUser['enabled'];
                }

                if($data['password'] === ''){
                    $data['password'] = $currentUser['password'];
                    $enc = 0;
                }else{
                    if(strlen($data['password']) < 6){
                        $errors['password'] = 'The password must have min. 6 characters';
                    }
                    if($data['password']!== $data['c_password']){
                        $errors['c_password'] = 'The password confirmation doesnt match.';
                    }
                    $enc = 1;
                }

                $uploadedFiles = $request->getUploadedFiles();

                if(empty($uploadedFiles['profile']->getClientFilename())){
                    $data['profile'] = $currentUser['profileimage'];
                }else{
                    $name = $uploadedFiles['profile']->getClientFilename();
                    $fileInfo = pathinfo($name);
                    $format = $fileInfo['extension'];
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
                        $data['enabled'],
                        new DateTime(),
                        new DateTime()
                    );

                    if($enc) {
                        $repository->update($user, $id, 1);
                    }else{
                        $repository->update($user, $id, 0);
                    }

                    $_SESSION['upd_ok'] = 1;
                }else {
                    //Algo ha ido mal
                    throw new \Exception('The validation went wrong');
                }
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