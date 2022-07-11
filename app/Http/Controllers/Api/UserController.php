<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\MemberPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected UserContract $userContract;

    /**
     * @param UserContract $userContract
     *
     */
    public function __construct(UserContract $userContract)
    {
        $this->userContract = $userContract;
    }

    /**
     * @param RegisterRequest $request
     * @return MessageResource
     */
    public function register(RegisterRequest $request): MessageResource
    {
        $user = ['name' => $request->name, 'password' => Hash::make($request->password), 'email' => $request->email,
            'phone' => $request->phone];
        $this->userContract->store($user);
        return new MessageResource(['success' => 1]);
    }

    /**
     * @param LoginRequest $request
     * @return MessageResource|UserResource
     */
    public function login(LoginRequest $request): MessageResource|UserResource
    {
        if (Auth::attempt($request->all())) {
            $accessToken = Auth::user()->createToken('authToken')->accessToken;
            return new UserResource(['success' => 1, 'user' => Auth::user(), 'accessToken' => $accessToken]);
        }
        return new MessageResource(['success' => 0]);
    }

    /**
     * @param Request $request
     * @return UserResource
     */
    public function getAuth(Request $request): UserResource
    {
        return new UserResource(['user' => Auth::user()]);
    }

    /**
     * @param Request $request
     * @return MessageResource
     */

    public function logout(Request $request): MessageResource
    {
        $user = Auth::user()->token();
        $user->revoke();
        return new MessageResource(['success' => 1]);
    }


    /**
     * @param MemberPasswordRequest $request
     * @return RedirectResponse
     */
    public function setMemberPassword(MemberPasswordRequest $request): RedirectResponse
    {
        $update = $this->userContract->setMemberPassword(['password' => Hash::make($request->input('password'))], $request->input('id'));
        return redirect()->to(route('welcome').'/login');
    }
}
