<?php

namespace App\Http\Controllers\Api;

use App\Contracts\LocationContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationCollection;
use App\Http\Resources\MessageResource;

class LocationController extends Controller
{

    protected LocationContract $locationContract;

    /**
     * @param LocationContract $locationContract
     */
    public function __construct(LocationContract $locationContract)
    {
        $this->locationContract = $locationContract;
    }

    /**
     * @return LocationCollection|MessageResource
     */

    public function index(): LocationCollection|MessageResource
    {
        $locations = $this->locationContract->getAll();
        return new LocationCollection(['success' => 1,'locations' => $locations]);

    }
}
