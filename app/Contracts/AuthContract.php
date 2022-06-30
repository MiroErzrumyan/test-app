<?php

namespace App\Contracts;

interface AuthContract
{


    /**
     * @param $data
     * @return array
     */

    public function register($data): array;
}
