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
            "INSERT into product(title, description, price, product_image,category, isActive) 
                        values(:title,:description,:price,:product_image,:category,:isActive)"
        );

        $title = $product->getTitle();
        $description = $product->getDescription();
        $price = $product->getPrice();
        $product_image = $product->getProductImage();
        $category = $product->getCategory();
        $isActive = $product->getisActive();

        $statement->bindParam('title', $title, PDO::PARAM_STR);
        $statement->bindParam('description', $description, PDO::PARAM_STR);
        $statement->bindParam('price', $price, PDO::PARAM_INT);
        $statement->bindParam('product_image', $product_image, PDO::PARAM_STR);
        $statement->bindParam('category', $category, PDO::PARAM_STR);
        $statement->bindParam('isActive', $isActive, PDO::PARAM_INT);

        $statement->execute();
    }

}