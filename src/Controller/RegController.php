<?php
/**
 * Created by PhpStorm.
 * User: Judit
 * Date: 13/04/2019
 * Time: 9:55
 */

namespace SallePW\SlimApp\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface;
use SallePW\SlimApp\Model\User;
use DateTime;


class RegController
{

    private const UPLOADS_DIR = __DIR__ . '/../../public/uploads';

    private const UNEXPECTED_ERROR = "An unexpected error occurred uploading the file '%s'...";

    private const INVALID_EXTENSION_ERROR = "The received file extension '%s' is not valid";

    // We use this const to define the extensions that we are going to allow
    private const ALLOWED_EXTENSIONS = ['jpg', 'png'];

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
        echo 'ok';
        //Lo que le pasamos a la vista
        return $this->container->get('view')->render($response, 'registration.twig', [
            'name' => 'ouh mama',
        ]);
    }
    public function regAction(Request $request, Response $response): Response
    {

        //poner return de la vista


        try {
            // This method decodes the received json
            $data = $request->getParsedBody();

            /** @var PDORepository $repository */
            $repository = $this->container->get('user_repo');

            //Validamos los campos y guardamos los errores
            $errors = $this->validate($data, $request, $response);

            //Control de los campos opcionales que son unos hijos de puta
            if(empty($data['birthdate'])){
                $aux= new DateTime("1000-01-01 00:00:00");
                $data['birthdate'] = $aux->format('Y-m-d H:i:s');
            }

            if(empty($data['profileimage'])){
                $data['profileimage'] = 'defaultProfile.png';
            }



            if(empty($errors)){
                //Como la seda
                $user = new User(
                    $data['name'],
                    $data['username'],
                    $data['email'],
                    $data['birthdate'],
                    $data['phonenumber'],
                    $data['password'],
                    $data['profileimage'],
                    0,                       //enabled, a 0 de saque
                    new DateTime(),
                    new DateTime()
                );

                $repository->save($user);
            }else{
                //Algo ha ido mal

                throw new \Exception('The validation went wrong');
            }




        } catch (\Exception $e) {

            //Si algo va mal al validar, mostramos la ventana de error

            $response->getBody()->write('Unexpected error: ' . $e->getMessage());
            $this->container->get('view')->render($response, 'error.twig', [
                'errors' => $errors,
            ]);
            return $response->withStatus(500);
        }
        $this->container->get('view')->render($response, 'login.twig');

        return $response->withStatus(201);



    }

    //Funcion para validar todos los campos antes de guardarlo
    private function validate(array $data, Request $request, Response $response): array
    {
        $errors = [];

        //NAME
        if (empty($data['name'])) {
            $errors['name'] = 'The name cannot be empty.';
        }elseif(!ctype_alnum($data['name'])){
            $errors['name'] = 'The name must be alphanumeric.';
        }

        //USERNAME
        if (empty($data['username'])) {
            $errors['username'] = 'The username cannot be empty.';
        }else{
            if(!ctype_alnum($data['username'])) {
                $errors['username'] = 'The username must be alphanumeric.';
            }

            if(strlen($data['username']) > 20){
                $errors['username'] = 'The username must have max. 20 characters';
            }
        }

        //FALTA AQUI LA MOVIDA CON LA BDDD PARA VER SI ES UNICO


        //EMAIL
        if (empty($data['email'])) {
            $errors['email'] = 'The email cannot be empty.';
        }elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'The email is not valid.';
        }


        //DATE OF BIRTH
        if(!empty($data['birthdate'])){

            $dateExploded = explode("-", $data['birthdate']);

            $day = $dateExploded[2];
            $month = $dateExploded[1];
            $year = $dateExploded[0];

            if(!checkdate($month, $day, $year)){

                $errors['birthdate'] = 'The birthdate is not valid.';
            }

        }


        //PHONE NUMBER
        if (empty($data['phonenumber'])) {

            $errors['phonenumber'] = 'The phone number cannot be empty.';
        }else {
            if (!preg_match( '/[0-9]{3}[ ][0-9]{3}[ ][0-9]{3}/', $data['phonenumber'])) {
                $errors['phonenumber'] = 'The phone number must follow the format xxx xxx xxx, only numbers.';
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

        //CONFIRM PASSWORD
        if (empty($data['c_password'])) {

            $errors['c_password'] = 'The password confirmation cannot be empty.';
        }elseif($data['password']!== $data['c_password']){

            $errors['c_password'] = 'The password confirmation doesnt match.';
        }

        //IMAGEN


        $uploadedFiles = $request->getUploadedFiles();



        if (isset($uploadedFiles['file'] )) {


            $errors['profile_image']= $this->imageChecking($uploadedFiles['profile'], $data['username']);
        }


        return $errors;
    }

    private function imageChecking(UploadedFileInterface $file, String $username): array
    {

        $errors = [];

        if ($file->getError() !== UPLOAD_ERR_OK) {

            $errors[] = sprintf(self::UNEXPECTED_ERROR, $file->getClientFilename());
            return $errors;
        }

        $name = $file->getClientFilename();

       $size = $file->getSize();

        $fileInfo = pathinfo($name);

        $format = $fileInfo['extension'];

        if (!$this->isValidFormat($format)) {
             $errors[] = sprintf(self::INVALID_EXTENSION_ERROR, $format);
            return $errors;
        }

       if($size > 500000){
           $errors[] = "Choosen image must not exceed 500 Kb";
           return $errors;
       }



            // We generate a custom name here instead of using the one coming form the form
        $file->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $username . "." . $format);

        return $errors;

    }

    private function isValidFormat(string $extension): bool
    {
        return in_array($extension, self::ALLOWED_EXTENSIONS, true);
    }

}




//PHP MAILER, SMTP, MAILNATOR