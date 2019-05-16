<?php

namespace SallePW\SlimApp\Model;

interface UserRepositoryInterface
{
    public function save(User $user);

    public function getData(int $id);

    public function update(User $user);

    public function deleteAccount(int $id);

    public function deleteProducts(string $userid);

    public function checkUniqueUsername(string $username);

    public function checkUniqueEmail(string $email);

    public function enableUserWithEmail(string $email);

    public function enableUserWithId();

    public function checkUser(bool $ismail, string $param);

    public function checkPassword(bool $ismail, string $password, string $login);

    public function checkEnabled();

    public function getId(string $username);

    public function getisActive(bool $ismail, string $param);
}
