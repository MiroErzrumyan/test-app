<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LocationCollection extends ResourceCollection
{
    /**
     * @param $request
     * @return array
     */

    public function toArray($request): array
    {
        return ['success' => $this['success'],'locations' => $this['locations'] ];
    }
}
