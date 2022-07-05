<?php

namespace App\Repositories;

use App\Contracts\TeamContract;
use App\Models\Team;
use Illuminate\Database\Eloquent\Model;

class TeamRepository implements TeamContract
{

    protected Team $team;

    /**
     * @param Team $team
     */
    public function __construct(Team $team){
        $this->team = $team;
    }

    /**
     * @param $data
     * @return Model
     */
    public function store($data):Model
    {
        return $this->team::create($data);
    }
}
