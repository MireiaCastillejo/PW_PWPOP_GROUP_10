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
            $this->container->get('view')->render($response, 'product_review.twig', ['product' => $products,'sesion' => $_SESSION['user_id']]);
        }else{
            $error[]="UN 403";
            $this->container->get('view')->render($response, 'error.twig', ['errors' => $error]);
            return $response->withStatus(403);
        }

        //$this->container->get('view')->render($response, 'product_review.twig', ['sesion' => $_SESSION['user_id']]);
    }

    public function getProductData(Request $request, Response $response,$id): Response
    {

        try {

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
    public function updateProduct(Request $request, Response $response, $array)
    {

        try {
            //session_start();

            //if ( isset( $_SESSION['user_id'] ) ) {


                $title = (json_decode($array['array'], true)['title']);
                $description = (json_decode($array['array'], true)['description']);
                $price = (json_decode($array['array'], true)['price']);
                $category = (json_decode($array['array'], true)['category']);
                $id = (json_decode($array['array'], true)['id']);

                /** @var PDORepository $repository * */
                $repository = $this->container->get('product_repo');

                $errors = [];

                //Title
                if (empty($title)) {
                    $errors['title'] = 'The title cannot be empty.';
                }

                //Description
                if (empty($description)) {
                    $errors['description'] = 'The description cannot be empty.';
                } else {
                    if (strlen($description)<20) {
                        $errors['description'] = 'The description must have min. 20 characters';
                    }
                    if (strlen($description) > 200) {
                        $errors['description'] = 'The description must have max. 200 characters';
                    }
                }

                //PRICE
                if (empty($price)) {

                    $errors['price'] = 'The price cannot be empty.';
                } else {
                    if(!is_numeric($price)) {

                        $errors['price'] = 'The price must be a number.';
                    }
                    $data['price'] = (float)$price;
                }

                //Category
                if (empty($category)) {
                    $errors['category'] = 'The category cannot be empty.';
                }


                if(empty($errors)){

                    $repository->updateProduct($title, $description, $price, $category, $id);
                    //$repository->updateProduct();
                }else {
                    //Algo ha ido mal

                    throw new \Exception('The validation went wrong');
                }


        } catch (\Exception $e) {

            $this->container->get('view')->render($response, 'myproducts.twig', ['errors' => $errors]);
            return $response->withStatus(400);
        }


        return $response->withRedirect('/myproducts',303);
    }

    public function getProductReview(Request $request, Response $response, $id): Response

    {

        try {

            if ( isset( $_SESSION['user_id'] ) ) {

                /** @var PDORepository $repository */
                $repository = $this->container->get('product_repo');
                $id=$id['id'];

                $products = $repository->getData($id);

                if($products['isSold']==1 ){
                    $error[]="404 el producto ha sido vendido";
                    $this->container->get('view')->render($response, 'error.twig', ['errors' => $error]);
                    return $response->withStatus(404);
                }
                elseif($products['isActive']==0 ){
                    $error[]="el producto ha sido borrado";
                    $this->container->get('view')->render($response, 'error.twig', ['errors' => $error]);

                } else {

                    $favs = $repository->mirafav($_SESSION['user_id'], $products['id']);

                    $this->container->get('view')->render($response, 'product_review.twig',
                        ['product' => $products, 'sesion' => $_SESSION['user_id'], 'fav' => $favs]);

                }
                if (!isset($products['title'])) {

                    $response = $response
                        ->withStatus(404)
                        ->write(json_encode(["message" => "oof", "res" => $products]));

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