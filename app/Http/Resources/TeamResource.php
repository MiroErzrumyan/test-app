<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{

    /**
     * @param $request
     * @return array
     */

    public function toArray($request): array
    {
        return ['success' => $this['success'],'office' => $this['team'] ];
    }
}
