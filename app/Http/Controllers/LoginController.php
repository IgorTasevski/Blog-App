<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserLoginRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\User\UserLoginInterface;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private readonly UserLoginInterface $userLoginRepository
    )
    {
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->validated();

        if (! $token = $this->userLoginRepository->login($credentials)) {
            return $this->errorResponse('Invalid Credentials', 401);
        }


        return $this->successResponse(new UserResource(Auth::user()), $token, 200);
    }
}
