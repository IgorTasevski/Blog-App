<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Abstracts\AbstractBaseRepository;
use App\Repositories\Interfaces\User\UserRegisterInterface;
use Illuminate\Support\Str;

class UserRegisterRepository
    extends AbstractBaseRepository
    implements UserRegisterInterface
{

    /**
     * @return string
     */
    protected function model(): string
    {
        return User::class;
    }

    /**
     * @var User $model;
     */
    protected $model;

    public function create(array $data): User
    {
        $data['uuid'] = (string) Str::uuid();
        $data['password'] = bcrypt($data['password']);
        return parent::create($data);
    }

}
