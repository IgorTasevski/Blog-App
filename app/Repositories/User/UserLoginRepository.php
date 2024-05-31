<?php

namespace App\Repositories\User;

use App\Repositories\Interfaces\User\UserLoginInterface;
use Illuminate\Support\Facades\Auth;

class UserLoginRepository
    implements UserLoginInterface
{
    public function login(array $data): string
    {
        if ($token = Auth::attempt($data)) {
            return $token;
        }
        return "Something went wrong!";
    }

}
