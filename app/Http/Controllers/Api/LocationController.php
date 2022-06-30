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
        $response = $this->locationContract->index();
        if ($response['success'] === 1 ){
            return new LocationCollection(['success' => $response['success'],'locations' => $response['locations']]);
        }
        return new MessageResource(['success' => 0]);

    }
}
