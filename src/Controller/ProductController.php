<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-05-08
 * Time: 12:49
 */

namespace SallePW\SlimApp\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use SallePW\SlimApp\Model\Product;
use Psr\Http\Message\UploadedFileInterface;


final class ProductController
{

    private const UPLOADS_DIR = __DIR__ . '/../../public/uploads';

    private const UNEXPECTED_ERROR = "An unexpected error occurred uploading the file '%s'...";

    private const INVALID_EXTENSION_ERROR = "The received file extension '%s' is not valid";

    // We use this const to define the extensions that we are going to allow
    private const ALLOWED_EXTENSIONS = ['jpg', 'png'];
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    public function myprod(Request $request, Response $response)
    {

        //session_start();
        $id=$_SESSION['user_id'];
        $repository = $this->container->get('product_repo');

        $repository_u = $this->container->get('user_repo');
        $enabled = $repository_u->checkEnabled();

        $products = $repository->get();
        $this->container->get('view')->render($response, 'myproducts.twig', ['products' => $products,'id'=>$id, 'enabled' => $enabled]);


    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $repository_u = $this->container->get('user_repo');
        $enabled = $repository_u->checkEnabled();
        $this->container->get('view')->render($response, 'upload.twig', ['enabled' => $enabled]);
    }

    public function uploadAction(Request $request, Response $response):Response
    {

        try {

            //session_start();
            if ( isset( $_SESSION['user_id'] ) ) {

                // This method decodes the received json
                $data = $request->getParsedBody();
                $repository = $this->container->get('product_repo');

                //Validamos los campos y guardamos los errores
                $errors = $this->validate($data, $request, $response);

                if (empty($data['product_image'])) {
                    $data['product_image'] = 'defaultProfile.png';
                }
                 $uploadedFiles = $request->getUploadedFiles();
                 $name = $uploadedFiles['product_image']->getClientFilename();

                 $fileInfo = pathinfo($name);

                 $format = $fileInfo['extension'];
                     $data['product_image'] = $data['title'].'.'.$format;




                if (empty($errors)) {

                    $product = new Product(
                        $_SESSION['user_id'],
                        $data['title'],
                        $data['description'],
                        $data['price'],
                        $data['product_image'],
                        $data['category'],
                        1
                    );


                    $repository->save($product);
                } else {
                    //Algo ha ido mal
                    throw new \Exception('The validation went wrong');
                }
            }
        } catch (\Exception $e) {

            $response->getBody()->write('Unexpected error: ' . $e->getMessage());

            //$this->container->get('view')->render($response, 'error.twig',['errors' => $errors,]);
            return $response->withStatus(500);
        }
        $repository = $this->container->get('product_repo');

        $products = $repository->get();

        $this->container->get('view')->render($response, 'loggeduser.twig', ['products' => $products,'sesion'=>$_SESSION['user_id']]);

        return $response->withStatus(201);


    }


    //Funcion para validar todos los campos antes de guardarlo
    private function validate(array $data, Request $request, Response $response): array
    {
        $errors = [];

        //title
        if (empty($data['title'])) {
            $errors['title'] = 'The title cannot be empty.';
        }

        //description
        if (empty($data['description'])) {
            $errors['description'] = 'The description cannot be empty.';
        } else {
            if (strlen($data['description'])<20) {
                $errors['description'] = 'The description must have min. 20 characters';
            }
        }


        //PASSWORD
        if (empty($data['price'])) {

            $errors['price'] = 'The price cannot be empty.';
            //Falta controlar el precio
        } else {

           $data['price']=(float)$data['price'];


        }



        $uploadedFiles = $request->getUploadedFiles();



        $aux = $uploadedFiles['product_image']->getClientFilename();


        if ($aux !== ""){


            $temp= $this->imageChecking($uploadedFiles['product_image'], $data['title']);


            if(isset($temp)){
                $errors['product_image'] = $temp;
            }

        }

        //CONFIRM Category
        if (empty($data['category'])) {
            $errors['category'] = 'The category cannot be empty.';
        }


        return $errors;
    }

    private function imageChecking(UploadedFileInterface $file, String $title) {


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

        if ($size > 1000000) {
            $errors[] = "Choosen image must not exceed 1Mb";
            return $errors;
        }


        // We generate a custom name here instead of using the one coming form the form
        $file->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $title . "." . $format);



    }

    private function isValidFormat(string $extension ): bool {
        return in_array($extension, self::ALLOWED_EXTENSIONS, true);
    }


}