<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface TeamContract
{
    /**
     * @param $data
     * @return Model
     */
    public function store($data): Model;
}
