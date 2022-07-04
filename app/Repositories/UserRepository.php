<?php

namespace App\Repositories;

use App\Contracts\UserContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserContract
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
     * @return Model
     */
    public function register($data): Model
    {
        return $this->user->create($data);
    }
}
