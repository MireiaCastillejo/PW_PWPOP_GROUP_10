<?php

namespace SallePW\Model;

interface UserRepository
{
    public function save(User $user);
}
