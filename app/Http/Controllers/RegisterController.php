<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\User\UserRegisterInterface;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private readonly UserRegisterInterface $userRegisterRepository
    )
    {
    }

    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->userRegisterRepository->create($data);

        $token = Auth::login($user);

        return $this->successResponse(new UserResource($user), $token, 201);
    }
}
