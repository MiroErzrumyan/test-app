<?php

namespace App\Repositories;

use App\Contracts\LocationContract;
use App\Models\Location;

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
     * @return array
     */
    public function index(): array
    {
        $locations = $this->location::all();
        if ($locations) {

            return ['success' => 1,'locations' => $this->location::all()];
        }
        return ['success' => 0];

    }
}
