<?php

namespace SallePW\SlimApp\Model\Database;

use PDO;
use SallePW\SlimApp\Model\User;
use SallePW\SlimApp\Model\UserRepositoryInterface;

final class PDORepository implements UserRepositoryInterface
{
    /** @var Database */
    private $database;

    /**
     * PDORepository constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function save(User $user)
    {

        echo '<script>console.log("inside save PDORepo")</script>';

        $statement = $this->database->getConnection()->prepare(
            "INSERT into user(name, username, email, birthdate, phonenumber, password, profileimage, enabled, is_active, created_at, updated_at) 
                        values(:name, :username, :email,:birthdate,:phonenumber, :password, :profileimage, :enabled, :is_active, :created_at, :updated_at)"
        );

        $name = $user->getName();
        $username = $user->getUserName();
        $email = $user->getEmail();
        $birthdate = $user->getBirthDate();
        $phonenumber = $user->getPhonenumber();
        $password = sha1($user->getPassword());
        $profileimage = $user->getProfileimage();
        $enabled = $user->getEnabled();
        $is_active = $user->getisActive();
        $createdAt = $user->getCreatedAt()->format('Y-m-d H:i:s');
        $updatedAt = $user->getUpdatedAt()->format('Y-m-d H:i:s');


        $statement->bindParam('name', $name, PDO::PARAM_STR);
        $statement->bindParam('username', $username, PDO::PARAM_STR);
        $statement->bindParam('birthdate', $birthdate, PDO::PARAM_STR);
        $statement->bindParam('phonenumber', $phonenumber, PDO::PARAM_STR);
        $statement->bindParam('email', $email, PDO::PARAM_STR);
        $statement->bindParam('password', $password, PDO::PARAM_STR);
        $statement->bindParam('profileimage', $profileimage, PDO::PARAM_STR);
        $statement->bindParam('enabled', $enabled, PDO::PARAM_STR);
        $statement->bindParam('is_active', $is_active, PDO::PARAM_STR);
        $statement->bindParam('created_at', $createdAt, PDO::PARAM_STR);
        $statement->bindParam('updated_at', $updatedAt, PDO::PARAM_STR);

        $statement->execute();
    }

    public function getData(string $username){

        $statement = $this->database->getConnection()->prepare(
            "SELECT * FROM user WHERE username = :username;"
        );

        $statement->bindParam('username', $username, PDO::PARAM_STR);

        $statement->execute();
        $res = $statement->fetch(PDO::FETCH_ASSOC);


        if($res != null){
            return[
                "name" => $res['name'],
                "username" => $res['username'],
                "email" => $res['email'],
                "birthdate" => $res['birthdate'],
                "phonenumber" => $res['phonenumber'],
                "profileimage" => $res['profileimage'],
            ];
        }else{
            return [];
        }

    }

    public function update(User $user){

        $statement = $this->database->getConnection()->prepare(
            "UPDATE user SET name = :name, email = :email, birthdate = :birthdate, phonenumber = :phonenumber, password = :password, profileimage = :profileimage, updated_at = :updated_at
                      WHERE username = :username;"
        );

        $name = $user->getName();
        $username = $user->getUserName();
        $email = $user->getEmail();
        $birthdate = $user->getBirthDate();
        $phonenumber = $user->getPhonenumber();
        $password = sha1($user->getPassword());
        $profileimage = $user->getProfileimage();
        $updatedAt = date('Y-m-d H:i:s');

        $statement->bindParam('name', $name, PDO::PARAM_STR);
        $statement->bindParam('username', $username, PDO::PARAM_STR);
        $statement->bindParam('email', $email, PDO::PARAM_STR);
        $statement->bindParam('birthdate', $birthdate, PDO::PARAM_STR);
        $statement->bindParam('phonenumber', $phonenumber, PDO::PARAM_STR);
        $statement->bindParam('password', $password, PDO::PARAM_STR);
        $statement->bindParam('profileimage', $profileimage, PDO::PARAM_STR);
        $statement->bindParam('updated_at', $updatedAt, PDO::PARAM_STR);

        $statement->execute();
    }


    public function deleteAccount(string $username){
        $statement = $this->database->getConnection()->prepare(
            "UPDATE user SET is_active = 0 WHERE username = :username"
        );
        $statement->bindParam('username', $username, PDO::PARAM_STR);

        $statement->execute();
    }

    public function checkUniqueUsername(string $username)
    {

        $statement = $this->database->getConnection()->prepare(

            "SELECT username FROM user WHERE username = :username;"
        );

        $statement->bindParam('username', $username, PDO::PARAM_STR);



        $statement->execute();

        $res = $statement->fetch(PDO::FETCH_ASSOC);



        return $res;



    }

    public function checkUniqueEmail(string $email)
    {

        $statement = $this->database->getConnection()->prepare(
            "SELECT * FROM user WHERE email = :email;"
        );

        $statement->bindParam('email', $email, PDO::PARAM_STR);

        $statement->execute();

        $res = $statement->fetch(PDO::FETCH_ASSOC);


        return $res;


    }

    public function enableUser(string $email){
        $statement = $this->database->getConnection()->prepare(
            "UPDATE user SET enabled = 1 WHERE email = :email ;"

        );

        $statement->bindParam('email', $email, PDO::PARAM_STR);

        return $res= $statement->execute();
    }

    public function checkUser(bool $ismail, string $param){

        //Nos pasan un email
        if($ismail){
            $statement = $this->database->getConnection()->prepare(
                "SELECT email FROM user WHERE  email = :param ;"
            );

            $statement->bindParam('param', $param, PDO::PARAM_STR);

            $statement->execute();

            $res = $statement->fetch(PDO::FETCH_ASSOC);


            return $res;
        }else{
            //Nos pasan un username
            $statement = $this->database->getConnection()->prepare(
                "SELECT username FROM user WHERE  username = :param ;"
            );

            $statement->bindParam('param', $param, PDO::PARAM_STR);

            $statement->execute();

            $res = $statement->fetch(PDO::FETCH_ASSOC);


            return $res;
        }

    }

    public function checkPassword(bool $ismail, string $password, string $login){
        //Nos pasan un email

        $password = sha1($password);
        if($ismail){
            $statement = $this->database->getConnection()->prepare(
                "SELECT password,email FROM user WHERE  email = :email AND password = :password;"
            );

            $statement->bindParam('email', $login, PDO::PARAM_STR);
            $statement->bindParam('password', $password, PDO::PARAM_STR);

            $statement->execute();

            $res = $statement->fetch(PDO::FETCH_ASSOC);


            return $res;
        }else{
            //Nos pasan un username
            $statement = $this->database->getConnection()->prepare(
                "SELECT password,username FROM user WHERE  username = :username AND password = :password;"
            );

            $statement->bindParam('username', $login, PDO::PARAM_STR);
            $statement->bindParam('password', $password, PDO::PARAM_STR);

            $statement->execute();

            $res = $statement->fetch(PDO::FETCH_ASSOC);


            return $res;
        }
    }

    public function checkEnabled(bool $ismail, string $login){

        //Nos pasan un email


        if($ismail){
            $statement = $this->database->getConnection()->prepare(
                "SELECT enabled FROM user WHERE  email = :email;"
            );

            $statement->bindParam('email', $login, PDO::PARAM_STR);

            $statement->execute();

            $res = $statement->fetch(PDO::FETCH_ASSOC);


            return $res;
        }else{
            //Nos pasan un username
            $statement = $this->database->getConnection()->prepare(
                "SELECT enabled FROM user WHERE  username = :username;"
            );

            $statement->bindParam('username', $login, PDO::PARAM_STR);

            $statement->execute();

            $res = $statement->fetch(PDO::FETCH_ASSOC);


            return $res;
        }
    }
}
