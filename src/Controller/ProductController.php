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

    private const UPLOADS_DIR = __DIR__ . '/../../public/uploads/products';

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

        $products = $repository->get();
        $this->container->get('view')->render($response, 'myproducts.twig', ['products' => $products,'id'=>$id]);


    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $this->container->get('view')->render($response, 'upload.twig', []);
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




                $uploadedFiles = $request->getUploadedFiles();
                $names ="";
                $i=0;
                /** @var UploadedFileInterface $uploadedFile */
                foreach ($uploadedFiles['files'] as $uploadedFile) {

                    $name=$uploadedFile->getClientFilename();
                    if($i==0){
                        $names=$name;

                    }else{
                        $names=$names.'/'.$name;
                    }


                    $i++;

                }
                $data['product_image'] = $names;

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

            //$response->getBody()->write('Unexpected error: ' . $e->getMessage());

            $this->container->get('view')->render($response, 'error.twig', ['errors' => $errors,]);
            return $response->withStatus(400);
        }
        $repository = $this->container->get('product_repo');

        $products = $repository->get();

        $this->container->get('view')->render($response, 'loggeduser.twig',
            ['products' => $products, 'sesion' => $_SESSION['user_id']]);

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
            if (strlen($data['description']) > 200) {
                $errors['description'] = 'The description must have max. 200 characters';
            }
        }


        //PASSWORD
        if (empty($data['price'])) {

            $errors['price'] = 'The price cannot be empty.';
            //Falta controlar el precio
        } else {
            if(!is_numeric($data['price'])) {

                $errors['price'] = 'The price must be a number.';
            }
            $data['price'] = (float)$data['price'];
        }


        $uploadedFiles = $request->getUploadedFiles();


        foreach ($uploadedFiles['files'] as $uploadedFile) {
            $name = $uploadedFile->getClientFilename();

            if (empty($name)) {
                $errors['product_image'] = 'The image cannot be empty.';

            } else {
                if ($name !== "") {

                    if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {

                        $errors['product_image'] = sprintf(self::UNEXPECTED_ERROR, $uploadedFile->getClientFilename());
                        return $errors;
                    }

                    $name = $uploadedFile->getClientFilename();
                    $size = $uploadedFile->getSize();
                    $fileInfo = pathinfo($name);

                    $format = $fileInfo['extension'];


                    if (!$this->isValidFormat($format)) {
                        $errors['product_image'] = sprintf(self::INVALID_EXTENSION_ERROR, $format);

                    }
                    if ($size > 1000000) {
                        $errors['product_image'] = "Choosen image must not exceed 1Mb";

                    }
                    $uploadedFile->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $name);

                }
            }
        }


        //CONFIRM Category
        if (empty($data['category'])) {
            $errors['category'] = 'The category cannot be empty.';
        }


        return $errors;
    }

    /*Esta funcion de momento no sirve pa na
    */
    private function imageChecking(UploadedFileInterface $file, String $title)
    {


        $errors = [];

        /** @var UploadedFileInterface $uploadedFile */
        //foreach ($uploadedFiles['files'] as $uploadedFile) {
            if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {

                $errors[] = sprintf(self::UNEXPECTED_ERROR, $uploadedFile->getClientFilename());
              return $errors;
            }

            $name = $uploadedFile->getClientFilename();
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
            //$uploadedFile->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR. $title . "." . format);
        $uploadedFile->moveTo(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $name);
      //  }



    }

    private function isValidFormat(string $extension ): bool {
        return in_array($extension, self::ALLOWED_EXTENSIONS, true);
    }





}