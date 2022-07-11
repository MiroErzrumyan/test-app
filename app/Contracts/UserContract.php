<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UserContract
{

    /**
     * @param $data
     * @return Model
     */
    public function store($data): Model;

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function setMemberPassword($data, $id): mixed;
}
