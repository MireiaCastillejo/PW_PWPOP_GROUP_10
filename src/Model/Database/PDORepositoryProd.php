<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-05-06
 * Time: 13:45
 */

namespace SallePW\SlimApp\Model\Database;

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

    public function save(Product $product) {
        $statement = $this->database->getConnection()->prepare(
            "INSERT into product(userid,title, description, price, product_image,category, isActive) 
                        values(:userid,:title,:description,:price,:product_image,:category,:isActive)"
        );

        $userid=$product->getUserid();
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

    public function get(){
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




}