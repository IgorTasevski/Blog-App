<?php

namespace App\Repositories\Interfaces\User;

use App\Models\User;

interface UserRegisterInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User;
}
