<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-05-16
 * Time: 20:33
 */

namespace SallePW\SlimApp\Controller;

use Psr\Container\ContainerInterface;
use SallePW\SlimApp\Model\Database\PDORepository;
use SallePW\SlimApp\Model\User;
use Slim\Http\Request;
use Slim\Http\Response;
use DateTime;

final class ProductReviewController
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

    }

    public function __invoke(Request $request, Response $response, $products)
    {
        // session_start();
        //$id = (int)$id['id'];
        if ( isset( $_SESSION['user_id'] ) ) {

            /*if($products['isSold']==1 ){
                $error[]="404 el producto ha sido vendido";
                $this->container->get('view')->render($response, 'error.twig', ['errors' => $error]);
                return $response->withStatus(404);
            }
            elseif($products['isActive']==0 ){
                $error[]="el producto ha sido borrado";
                $this->container->get('view')->render($response, 'error.twig', ['errors' => $error]);

            }else {*/
                $this->container->get('view')->render($response, 'product_review.twig',
                    ['product' => $products, 'sesion' => $_SESSION['user_id']]);

            //}
        }else{
            $error[]="UN 403";
            $this->container->get('view')->render($response, 'error.twig', ['errors' => $error]);
            return $response->withStatus(403);
        }

        //$this->container->get('view')->render($response, 'product_review.twig', ['sesion' => $_SESSION['user_id']]);
    }

    public function getProductData(Request $request, Response $response, $id): Response

    {

        try {

            //if ( isset( $_SESSION['user_id'] ) ) {

                /** @var PDORepository $repository */
                $repository = $this->container->get('product_repo');
                $id=$id['id'];
                $data = $repository->getData($id);

                if (!isset($data['title'])) {

                    $response = $response
                        ->withStatus(404)
                        ->write(json_encode(["message" => "oof", "res" => $data]));

                } else {
                    $response = $response
                        ->withStatus(200)
                        ->write(json_encode(["message" => "correcto producto", "res" => $data]));
                }
            //}
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

                //add username to data array
                $data['username']='user1';

                /** @var PDORepository $repository * */
                $repository = $this->container->get('user_repo');

                //Validamos los campos y guardamos los errores
                $regController = new RegController($this->container);
                $errors = $regController->validate($data, $request, true);

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
                        $id,
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

                    $repository->update($user);


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

    public function getProductReview(Request $request, Response $response, $id): Response

    {

        try {

            if ( isset( $_SESSION['user_id'] ) ) {

                /** @var PDORepository $repository */
                $repository = $this->container->get('product_repo');
                $id=$id['id'];

                $data = $repository->getData($id);

               // $this->container->get('view')->render($response, 'product_review.twig', ['product'=>$data,'sesion' => $_SESSION['user_id']]);
                $this->__invoke($request, $response, $data);
                if (!isset($data['title'])) {

                    $response = $response
                        ->withStatus(404)
                        ->write(json_encode(["message" => "oof", "res" => $data]));

                } else {
                    $response = $response
                        ->withStatus(200);



                }
            }
        } catch (\Exception $e) {
            $response = $response
                ->withStatus(500)
                ->write(json_encode(["message"=>"nope", "res"=>$e]));

        }
        return $response;
    }

}