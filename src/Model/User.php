<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-04-17
 * Time: 17:37
 */

namespace SallePW\SlimApp\Model;


class User
{
    private $id;
    private $userName;
    private $password;
    private $email;
    private $birthDate;
    private $created_at;
    private $updated_at;

    /**
     * User constructor.
     * @param $id
     * @param $userName
     * @param $password
     * @param $email
     * @param $birthDate
     * @param $created_at
     * @param $updated_at
     */
    public function __construct($id, $userName, $password, $email, $birthDate, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->password = $password;
        $this->email = $email;
        $this->birthDate = $birthDate;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param mixed $birthDate
     */
    public function setBirthDate($birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }



}