<?php
/**
 * Created by PhpStorm.
 * User: universidad
 * Date: 2019-04-17
 * Time: 17:49
 */

namespace SallePW\SlimApp\Model;


use SallePW\Model\User;
use SallePW\Model\UserRepository;

class MySQLUserRepository implements UserRepository
{

    public function save(User $user)
    {
        $servername = "192.168.10.10";
        $username = "homestead";
        $password = "secret";


        $db = new PDO("mysql:host=localhost;dbname=homestead", $username, $password);


        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);


        $id = $user->getId();
        $userName = $user->getUserName();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $birthDate = $user->getBirthDate();
        $created_at = $user->getCreatedAt()->format('Y-m-d-H-i-s');
        $updated_at = $user->getUpdatedAt()->format('Y-m-d-H-i-s');

        try {
            $query = $query = "INSERT INTO user(id,userName,password,email,birthDate,created_at,updated_at) VALUES (?,?,?,?,?,?,?)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $userName);
            $stmt->bindParam(3, $password);
            $stmt->bindParam(4, $email);
            $stmt->bindParam(5, $birthDate);
            $stmt->bindParam(6, $created_at);
            $stmt->bindParam(7, $updated_at);

            if($stmt->execute()) {
                echo "<script>alert('User was registered.');location.href='/register'</script>";
            } else {

            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}