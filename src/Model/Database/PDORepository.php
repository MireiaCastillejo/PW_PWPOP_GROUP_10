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

        $statement = $this->database->getConnection()->prepare(
            "INSERT into user(name, username, email, birthdate, phonenumber, password, profileimage, is_active, enabled, created_at, updated_at) 
                        values(:name, :username, :email,:birthdate,:phonenumber, :password, :profileimage,  :is_active, :enabled, :created_at, :updated_at)"
        );

        $name = $user->getName();
        $username = $user->getUserName();
        $email = $user->getEmail();
        $birthdate = $user->getBirthDate();
        $phonenumber = $user->getPhonenumber();
        $password = sha1($user->getPassword());
        $profileimage = $user->getProfileimage();
        $is_active = $user->getisActive();
        $enabled = $user->getEnabled();
        $createdAt = $user->getCreatedAt()->format('Y-m-d H:i:s');
        $updatedAt = $user->getUpdatedAt()->format('Y-m-d H:i:s');


        $statement->bindParam('name', $name, PDO::PARAM_STR);
        $statement->bindParam('username', $username, PDO::PARAM_STR);
        $statement->bindParam('birthdate', $birthdate, PDO::PARAM_STR);
        $statement->bindParam('phonenumber', $phonenumber, PDO::PARAM_STR);
        $statement->bindParam('email', $email, PDO::PARAM_STR);
        $statement->bindParam('password', $password, PDO::PARAM_STR);
        $statement->bindParam('profileimage', $profileimage, PDO::PARAM_STR);
        $statement->bindParam('is_active', $is_active, PDO::PARAM_STR);
        $statement->bindParam('enabled', $enabled, PDO::PARAM_STR);
        $statement->bindParam('created_at', $createdAt, PDO::PARAM_STR);
        $statement->bindParam('updated_at', $updatedAt, PDO::PARAM_STR);

        $statement->execute();
    }

    public function getData(int $id){

        $statement = $this->database->getConnection()->prepare(
            "SELECT * FROM user WHERE id = :id;"
        );

        $statement->bindParam('id', $id, PDO::PARAM_INT);

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
                "enabled" => $res['enabled'],
            ];
        }else{
            return [];
        }

    }

    public function update(User $user, int $id_user){

        $statement = $this->database->getConnection()->prepare(
            "UPDATE user SET name = :name, email = :email, birthdate = :birthdate, phonenumber = :phonenumber, 
                      password = :password, profileimage = :profileimage, updated_at = :updated_at 
                      WHERE id = :id;");

        $name = $user->getName();
        $username = $user->getUserName();
        $email = $user->getEmail();
        $birthdate = $user->getBirthDate();
        $phonenumber = $user->getPhonenumber();
        $password = sha1($user->getPassword());
        $profileimage = $user->getProfileimage();
        $updatedAt = date('Y-m-d H:i:s');

        $statement->bindParam('name', $name, PDO::PARAM_STR);
        $statement->bindParam('email', $email, PDO::PARAM_STR);
        $statement->bindParam('birthdate', $birthdate, PDO::PARAM_STR);
        $statement->bindParam('phonenumber', $phonenumber, PDO::PARAM_STR);
        $statement->bindParam('password', $password, PDO::PARAM_STR);
        $statement->bindParam('profileimage', $profileimage, PDO::PARAM_STR);
        $statement->bindParam('updated_at', $updatedAt, PDO::PARAM_STR);
        $statement->bindParam('id', $id_user, PDO::PARAM_STR);

        var_dump($statement);
        $statement->execute();
    }

    public function deleteAccount(int $id){
        $statement = $this->database->getConnection()->prepare(
            "UPDATE user SET is_active = 0 WHERE id = :id"
        );
        $statement->bindParam('id', $id, PDO::PARAM_STR);

        $statement->execute();
    }

    public function deleteProducts(string $userid){
        $statement = $this->database->getConnection()->prepare(
            "UPDATE product SET isActive = 0 WHERE userid = :userid"
        );
        $statement->bindParam('userid', $userid, PDO::PARAM_STR);

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

    //Activar cuenta
    public function enableUserWithEmail(string $email){
        $statement = $this->database->getConnection()->prepare(
            "UPDATE user SET enabled = 1 WHERE email = :email ;"

        );

        $statement->bindParam('email', $email, PDO::PARAM_STR);

        return $res= $statement->execute();
    }

    //Activar cuenta
    public function enableUserWithId(){
        $statement = $this->database->getConnection()->prepare(
            "UPDATE user SET enabled = 1 WHERE id= :id ;"

        );

        $id = (int)$_SESSION['user_id'];

        $statement->bindParam('id', $id, PDO::PARAM_STR);

        return $res= $statement->execute();
    }

    //Para comprobar que el usuario existe
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

    //comprobar contraseña
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

    public function checkEnabled(){




        $statement = $this->database->getConnection()->prepare(
            "SELECT enabled FROM user WHERE  id = :id;"
        );

        $user_id = (int)$_SESSION['user_id'];

        $statement->bindParam('id', $user_id, PDO::PARAM_STR);

        $statement->execute();

        $res = $statement->fetch(PDO::FETCH_ASSOC);


        return $res['enabled'];

    }

    public function getId(string $username){
        $statement = $this->database->getConnection()->prepare(
            "SELECT id FROM user WHERE username=:username"
        );
        $statement->bindParam('username', $username, PDO::PARAM_STR);

       $statement->execute();
       $id=$statement->fetch();
        return $id;
    }

    public function getUsername(int $id){
        $statement = $this->database->getConnection()->prepare(
            "SELECT username FROM user WHERE id=:id"
        );
        $statement->bindParam('id', $id, PDO::PARAM_STR);

        $statement->execute();
        $username=$statement->fetch();
        return $username;
    }

    public function getisActive(bool $ismail,string $param){
        //Nos pasan un email
        if($ismail){
            $statement = $this->database->getConnection()->prepare(
                "SELECT is_active FROM user WHERE  email = :param ;"
            );

            $statement->bindParam('param', $param, PDO::PARAM_STR);

            $statement->execute();

            $res = $statement->fetch(PDO::FETCH_ASSOC);


            return $res;
        }else{
            //Nos pasan un username
            $statement = $this->database->getConnection()->prepare(
                "SELECT is_active FROM user WHERE  username = :param ;"
            );

            $statement->bindParam('param', $param, PDO::PARAM_STR);

            $statement->execute();

            $res = $statement->fetch(PDO::FETCH_ASSOC);


            return $res;
        }
    }

    public function getEmail(int $id){
        $statement = $this->database->getConnection()->prepare(
            "SELECT email FROM user WHERE id=:id"
        );


        $statement->bindParam('id', $id, PDO::PARAM_STR);

        $statement->execute();
        $res=$statement->fetch();
        return $res['email'];
    }




    public function getPhone(int $id){

        $statement = $this->database->getConnection()->prepare(
            "SELECT phonenumber FROM user WHERE id=:id"
        );

        $statement->bindParam('id', $id, PDO::PARAM_STR);

        $statement->execute();
        $res=$statement->fetch();

        return $res['phonenumber'];

    }

    public function getUsernameAndPassword(int $id){

        $statement = $this->database->getConnection()->prepare(
            "SELECT * FROM user WHERE id = :id;"
        );

        $statement->bindParam('id', $id, PDO::PARAM_INT);

        $statement->execute();
        $res = $statement->fetch(PDO::FETCH_ASSOC);


        if($res != null){

            return[

                "username" => $res['username'],
                "password" => $res['password']
            ];
        }else{
            return [];
        }

    }
}
