<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UserContract
{

    /**
     * @param $data
     * @return Model
     */
    public function register($data): Model;
}
