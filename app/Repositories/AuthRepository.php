<?php

namespace App\Repositories;

use App\Contracts\AuthContract;
use App\Models\User;

class AuthRepository implements AuthContract
{
    protected User $user;

    /**
     * @param User $user
     */

    public function __construct(User $user)

    {
        $this->user = $user;
    }


    /**
     * @param $data
     * @return int[]
     */

    public function register($data): array
    {
        $user = $this->user->create($data);
        if($user){

            return ['success' => 1];
        }
        return ['success' => 0];

    }
}
