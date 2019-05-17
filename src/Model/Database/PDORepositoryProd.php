<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-05-06
 * Time: 13:45
 */

namespace SallePW\SlimApp\Model\Database;

use http\Encoding\Stream\Inflate;
use PDO;

use SallePW\SlimApp\Model\Product;
use SallePW\SlimApp\Model\ProductRepositoryInterface;

final class PDORepositoryProd implements ProductRepositoryInterface
{

    /** @var Database */
    private $database;

    /**
     * PDORepositoryProd constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function save(Product $product)
    {
        $statement = $this->database->getConnection()->prepare(
            "INSERT into product(userid,title, description, price, product_image,category, isActive) 
                        values(:userid,:title,:description,:price,:product_image,:category,:isActive)"
        );

        $userid = $product->getUserid();
        $title = $product->getTitle();
        $description = $product->getDescription();
        $price = strval($product->getPrice());
        $product_image = $product->getProductImage();
        $category = $product->getCategory();
        $isActive = $product->getisActive();

        $statement->bindParam('userid', $userid, PDO::PARAM_INT);
        $statement->bindParam('title', $title, PDO::PARAM_STR);
        $statement->bindParam('description', $description, PDO::PARAM_STR);
        $statement->bindParam('price', $price, PDO::PARAM_STR);
        $statement->bindParam('product_image', $product_image, PDO::PARAM_STR);
        $statement->bindParam('category', $category, PDO::PARAM_STR);
        $statement->bindParam('isActive', $isActive, PDO::PARAM_INT);

        $statement->execute();
    }

    public function get()
    {
        $statement = $this->database->getConnection()->prepare(
            "SELECT * FROM product"
        );

        $statement->execute();
        $product = $statement->fetchAll();
        return $product;
    }


    public function favourite(int $id)
    {
        $statement = $this->database->getConnection()->prepare(
            'update product set isFav =1 where id =:id');
        $statement->bindParam('id', $id, PDO::PARAM_INT);
        $statement->execute();

    }


    public function buy(int $id)
    {
        $statement = $this->database->getConnection()->prepare(
            'update product set isSold =1 where id =:id');
        $statement->bindParam('id', $id, PDO::PARAM_INT);
        $statement->execute();

    }


    public function getData(int $id)
    {
        $statement = $this->database->getConnection()->prepare(
            "SELECT * FROM product WHERE id = :id;"
        );

        $statement->bindParam('id', $id, PDO::PARAM_INT);

        $statement->execute();
        $res = $statement->fetch(PDO::FETCH_ASSOC);

        if ($res != null) {

            return [
                "id"=> $res['id'],
                "title" => $res['title'],
                "description" => $res['description'],
                "price" => $res['price'],
                "product_image" => $res['product_image'],
                "category" => $res['category'],
                "isActive"=> $res['isActive'],
                "isSold"=> $res['isSold'],
            ];
        } else {
            return [];
        }


    }

    public function searchProduct(string $title, string $category, float $pricemin, float $pricemax)
    {


        if (empty($title) and empty($pricemin) and empty($pricemax)) {
            $statement = $this->database->getConnection()->prepare(
                "SELECT * FROM product WHERE category = :category ;"
            );

            $statement->bindParam('category', $category, PDO::PARAM_STR);

            $statement->execute();
            $product = $statement->fetchAll();
        } elseif (empty($title) and empty($pricemax)) {
            $statement = $this->database->getConnection()->prepare(
                "SELECT * FROM product WHERE category = :category and  price>=:pricemin;"
            );
            $statement->bindParam('pricemin', $pricemin, PDO::PARAM_INT);
            $statement->bindParam('category', $category, PDO::PARAM_STR);
            $statement->execute();
            $product = $statement->fetchAll();
        } elseif (empty($title) and empty($pricemin)) {

            $statement = $this->database->getConnection()->prepare(
                "SELECT * FROM product WHERE category = :category and  price<:pricemax;"
            );
            $statement->bindParam('pricemax', $pricemax, PDO::PARAM_INT);
            $statement->bindParam('category', $category, PDO::PARAM_STR);
            $statement->execute();
            $product = $statement->fetchAll();
        } elseif (empty($title)) {
            $statement = $this->database->getConnection()->prepare(
                "SELECT * FROM product WHERE category = :category and price>=:pricemin and price<:pricemax;"
            );
            $statement->bindParam('pricemin', $pricemin, PDO::PARAM_INT);
            $statement->bindParam('pricemax', $pricemax, PDO::PARAM_INT);
            $statement->bindParam('category', $category, PDO::PARAM_STR);
            $statement->execute();
            $product = $statement->fetchAll();

        } elseif (empty($pricemin)) {

            $statement = $this->database->getConnection()->prepare(
                "SELECT * FROM product WHERE title = :title and category = :category and price<:pricemax;"
            );
            $statement->bindParam('title', $title, PDO::PARAM_STR);
            $statement->bindParam('category', $category, PDO::PARAM_STR);
            $statement->bindParam('pricemax', $pricemax, PDO::PARAM_INT);

            $statement->execute();
            $product = $statement->fetchAll();

        } elseif (empty($pricemin) and empty($pricemax)) {

            $statement = $this->database->getConnection()->prepare(
                "SELECT * FROM product WHERE title = :title and category = :category ;"
            );
            $statement->bindParam('title', $title, PDO::PARAM_STR);
            $statement->bindParam('category', $category, PDO::PARAM_STR);
            $statement->execute();
            $product = $statement->fetchAll();
        } elseif (empty($pricemax)) {


            $statement = $this->database->getConnection()->prepare(
                "SELECT * FROM product WHERE title = :title and category = :category and price>=:pricemin ;"
            );
            $statement->bindParam('title', $title, PDO::PARAM_STR);
            $statement->bindParam('category', $category, PDO::PARAM_INT);
            $statement->bindParam('pricemin', $pricemin, PDO::PARAM_INT);
            $statement->execute();
            $product = $statement->fetchAll();
        } else {

            $statement = $this->database->getConnection()->prepare(
                "SELECT * FROM product WHERE title = :title and category = :category and price>=:pricemin and price<:pricemax;"
            );

            $statement->bindParam('title', $title, PDO::PARAM_STR);
            $statement->bindParam('category', $category, PDO::PARAM_STR);
            $statement->bindParam('pricemin', $pricemin, PDO::PARAM_INT);
            $statement->bindParam('pricemax', $pricemax, PDO::PARAM_INT);


            $statement->execute();
            $product = $statement->fetchAll();
        }

        return $product;
    }







}