<?php

namespace App\Http\Controllers\Api;

use App\Contracts\TeamContract;
use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\TeamStoreRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\UserResource;
use App\Services\MailService;
use Illuminate\Http\Request;

class TeamController extends Controller
{

    protected TeamContract $teamContract;
    protected UserContract $userContract;

    /**
     * @param TeamContract $teamContract
     */
    public function __construct(TeamContract $teamContract,UserContract $userContract)
    {
        $this->teamContract = $teamContract;
        $this->userContract = $userContract;
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


    /**
     * @param CreateMemberRequest $request
     * @param $id
     * @return MessageResource
     */
    public function createMember(CreateMemberRequest $request, $id): MessageResource
    {
        $member = $this->userContract->store($request->input());
        $member->teams()->sync($id);
        $email = new MailService();
        $email->sendMail($member['email'],$member['id']);
        return new MessageResource(['success' => 1]);
    }
}
