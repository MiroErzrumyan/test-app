<?php

namespace App\Repositories;

use App\Contracts\LocationContract;
use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationRepository implements LocationContract
{

    protected Location $location;

    /**
     * @param Location $location
     */

    public function __construct(Location $location)
    {
        $this->location = $location;
    }


    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->location::all();
    }
}
