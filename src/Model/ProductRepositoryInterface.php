<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-05-06
 * Time: 13:43
 */

namespace SallePW\SlimApp\Model;


interface ProductRepositoryInterface
{
    public function save(Product $product);

}