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

    private $name;
    private $username;
    private $email;
    private $birthdate;
    private $phonenumber;
    private $password;
    private $profileimage;
    private $is_active;
    private $enabled;
    private $createdat;
    private $updatedat;



    /**
     * User constructor.
     * @param $name
     * @param $username
     * @param $email
     * @param $birthdate
     * @param $phonenumber
     * @param $password
     * @param $profileimage
     * @param $is_active
     * @param $enabled
     * @param $createdat
     * @param $updatedat
     */
    public function __construct( $name, $username, $email, $birthdate, $phonenumber, $password, $profileimage, $is_active, $enabled , $createdat, $updatedat)
    {

        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->phonenumber = $phonenumber;
        $this->password = $password;
        $this->profileimage = $profileimage;
        $this->is_active= $is_active;
        $this->enabled = $enabled;
        $this->createdat = $createdat;
        $this->updatedat = $updatedat;
    }


    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUserName($username): void
    {
        $this->username = $username;
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
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthDate($birthdate): void
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdat;
    }

    /**
     * @param mixed $createdat
     */
    public function setCreatedAt($createdat): void
    {
        $this->createdat = $createdat;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedat;
    }

    /**
     * @param mixed $updatedat
     */
    public function setUpdatedAt($updatedat): void
    {
        $this->updatedat = $updatedat;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * @param mixed $phonenumber
     */
    public function setPhonenumber($phonenumber): void
    {
        $this->phonenumber = $phonenumber;
    }

    /**
     * @return mixed
     */
    public function getProfileimage()
    {
        return $this->profileimage;
    }

    /**
     * @param mixed $profileimage
     */
    public function setProfileimage($profileimage): void
    {
        $this->profileimage = $profileimage;
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }


    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->is_active;
    }

    /**
     * @param mixed $is_active
     */
    public function setIsActive($is_active): void
    {
        $this->is_active = $is_active;
    }

}