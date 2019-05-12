<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-04-17
 * Time: 17:37
 */

namespace SallePW\SlimApp\Model;


class Product
{
    private $id;
    private $userid;
    private $title;
    private $description;
    private $price;
    private $product_image;
    private $category;
    private $isActive;
    private $isFav;

    /**
     * Product constructor.
     * @param $userid
     * @param $title
     * @param $description
     * @param $price
     * @param $product_image
     * @param $category
     * @param $isActive
     */
    public function __construct($userid, $title, $description, $price, $product_image, $category, $isActive)
    {
        $this->userid = $userid;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->product_image = $product_image;
        $this->category = $category;
        $this->isActive = $isActive;
    }


    /**
     * @return mixed
     */
    public function getisFav()
    {
        return $this->isFav;
    }

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid): void
    {
        $this->userid = $userid;
    }

    /**
     * @param mixed $isFav
     */
    public function setIsFav($isFav): void
    {
        $this->isFav = $isFav;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }



    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getProductImage()
    {
        return $this->product_image;
    }

    /**
     * @param mixed $product_image
     */
    public function setProductImage($product_image): void
    {
        $this->product_image = $product_image;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }
}