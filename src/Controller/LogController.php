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
    private $ismail;
    private const COOKIES_REG_OK= 'reg_ok';


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

        //Cookie para ver si el reg ha ido ok
        $regCookie = FigRequestCookies::get($request, self::COOKIES_REG_OK);
        $reg_ok = $regCookie->getValue();

        //Poner mensaje si no esta enabled
        if(($_SESSION['enabled']) === 1 ){
            $isenabled=1;
        }else{
            $isenabled = 0;
        }



        //Lo que le pasamos a la vista
        return $this->container->get('view')->render($response, 'login.twig',
            [
                'reg_ok'=> $reg_ok, 'enabled' => $isenabled
            ]);
    }
    public function logAction(Request $request, Response $response): Response
    {


        try {
            // This method decodes the received json
            $data = $request->getParsedBody();


            /** @var PDORepository $repository**/
            $repository = $this->container->get('user_repo');

            //Validamos los campos y guardamos los errores
            $errors = $this->validate($data, $request);


            if (empty($errors)) {

                $datauser = $repository->getisActive($this->getIsMail(), $data['login']);
                if ($datauser['is_active'] == '1') {

                //Como la seda, no ha habido errores

                //Comprobamos que el usuario existe
                $existe = $repository->checkUser($this->getIsMail(), $data['login']);

                if ($existe) {

                    //Si existe, comprobamos que la contraseña sea correcta
                    $correctPassword = $repository->checkPassword($this->getIsMail(),$data['password'], $data['login']);

                    //Si la contraseña es correcta comprobamos que se haya activado la cuenta
                    if($correctPassword){

                        $enabled = $repository->checkEnabled($this->getIsMail(),$data['login']);



                       //var_dump($enabled["enabled"]);
                        if($enabled["enabled"] == '1'){
                            //var_dump("esta enabled");

                            $id=$repository->getId($data['login']);
                        }else{
                            //FALTA: añadir el link de activacion
                            $msg = ('Please check your email or click here to resend the activation link FOOL');
                            throw new \Exception($msg);
                        }

                        //GESTION DEL CHECKBOX
                        //var_dump($data['rememberme']);

                    } else {
                        throw new \Exception('Wrong password');
                    }
                } else {
                    throw new \Exception('This username/email doesnt exist');
                }

            }else {
                    throw new \Exception('The user is deleted');
                }
            }else {
                //Algo ha ido mal
                throw new \Exception('The validation went wrong');
            }


        } catch (\Exception $e) {

            //Si algo va mal al validar, mostramos la ventana de error

           // $response->getBody()->write('Unexpected error: ' . $e->getMessage());
           $this->container->get('view')->render($response, 'login.twig', [
                'errors' => $errors, 'bbdderrors' =>$e->getMessage()
            ]);
            return $response->withStatus(500);
        }

       // session_start();

        //Mostramos la vista del login
        $_SESSION['user_id'] = $id['id'];
        $_SESSION['enabled'] = 0;

        //$this->container->get('view')->render($response, 'index.twig');

        return $response->withRedirect('/',303);
    }

    public function validate(array $data)
    {

        $errors = [];

        if(filter_var($data['login'], FILTER_VALIDATE_EMAIL)){
            $this->setIsMail(true);


            //EMAIL
            if (empty($data['login'])) {
                $errors['login'] = 'The email cannot be empty.';
            }else{

                if(!filter_var($data['login'], FILTER_VALIDATE_EMAIL)){
                    $errors['login'] = 'The email is not valid.';
                }

            }
        }else{
            $this->setIsMail(false);
            //USERNAME
            if (empty($data['login'])) {
                $errors['login'] = 'The username cannot be empty.';
            }else{
                if(!ctype_alnum($data['login'])) {
                    $errors['login'] = 'The username must be alphanumeric.';
                }

                if(strlen($data['login']) > 20){
                    $errors['login'] = 'The username must have max. 20 characters';
                }

            }
        }

        //PASSWORD
        if (empty($data['password'])) {

            $errors['password'] = 'The password cannot be empty.';
        }else {
            if(strlen($data['password']) < 6){
                $errors['password'] = 'The password must have min. 6 characters';
            }
        }

        return $errors;
    }


    /**
     * @return mixed
     */
    public function getIsMail()
    {
        return $this->ismail;
    }

    /**
     * @param mixed $op
     */
    public function setIsMail($ismail): void
    {
        $this->ismail = $ismail;
    }
}