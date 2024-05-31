<?php

namespace App\Repositories\Interfaces\User;

interface UserLoginInterface
{
    /**
     * @param array $data
     * @return string
     */
    public function login(array $data): string;
}
