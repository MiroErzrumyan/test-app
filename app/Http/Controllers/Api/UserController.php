<?php

namespace App\Http\Controllers\Api;

use App\Contracts\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
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
        $user = ['name' => $request->name, 'password' => Hash::make($request->password), 'email' => $request->email];
        $this->userContract->register($user);
        return new MessageResource(['success' => 1] );
    }

    /**
     * @param LoginRequest $request
     * @return MessageResource|UserResource
     */
    public function login(LoginRequest $request): MessageResource|UserResource
    {
        if (Auth::attempt($request->all())) {
            $accessToken = Auth::user()->createToken('authToken')->accessToken;
            $user = Auth::user();
            return new UserResource(['success' => 1, 'user' => $user, 'accessToken' => $accessToken]);
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

}
