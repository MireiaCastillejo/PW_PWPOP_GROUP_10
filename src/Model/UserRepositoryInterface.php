<?php

namespace SallePW\SlimApp\Model;

interface UserRepositoryInterface
{
    public function save(User $user);

    public function getData(int $id);

    public function update(User $user, int $id);

    public function deleteAccount(int $id);

    public function deleteProducts(string $userid);

    public function checkUniqueUsername(string $username);

    public function checkUniqueEmail(string $email);

    public function enableUser(string $email);

    public function checkUser(bool $ismail, string $param);

    public function checkPassword(bool $ismail, string $password, string $login);

    public function checkEnabled(bool $ismail, string $login);

    public function getId(string $username);

    public function getisActive(bool $ismail, string $param);
}
