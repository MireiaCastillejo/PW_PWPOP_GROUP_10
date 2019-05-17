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

    public function get();

    public function favourite(int $id);
    public function buy(int $id);
    public function getData(int $userid);
    public function searchProduct(string $title,string $category,float $pricemin,float $pricemax);


    }