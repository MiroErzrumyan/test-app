<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface LocationContract
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;
}
