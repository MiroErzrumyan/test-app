<?php

namespace App\Http\Controllers\Api;

use App\Contracts\TeamContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    protected TeamContract $teamContract;


    /**
     * @param TeamContract $teamContract
     */
    public function __construct(TeamContract $teamContract)
    {
        $this->teamContract = $teamContract;
    }

    /**
     * @param TeamStoreRequest $request
     * @return TeamResource
     */
    public function store(TeamStoreRequest $request): TeamResource
    {
        $team = $this->teamContract->store($request->input());
        return new TeamResource(['success' => 1, 'team' => $team]);
    }
}
