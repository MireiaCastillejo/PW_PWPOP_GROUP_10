<?php

namespace SallePW\Model\Services;


class PostUserService
{

    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(User $user)
    {
        $this->repository->save($user);
    }
}
