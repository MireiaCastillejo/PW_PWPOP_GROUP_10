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
            "INSERT into user(name, username, email, birthdate, phonenumber, password, profileimage, enabled, created_at, updated_at) 
                        values(:name, :username, :email,:birthdate,:phonenumber, :password, :profileimage, :enabled, :created_at, :updated_at)"
        );

        $name = $user->getName();
        $username = $user->getUserName();
        $email = $user->getEmail();
        $birthdate = $user->getBirthDate();
        $phonenumber = $user->getPhonenumber();
        $password = sha1($user->getPassword());
        $profileimage = $user->getProfileimage();
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
        $statement->bindParam('enabled', $enabled, PDO::PARAM_STR);
        $statement->bindParam('created_at', $createdAt, PDO::PARAM_STR);
        $statement->bindParam('updated_at', $updatedAt, PDO::PARAM_STR);

        $statement->execute();
    }
}
