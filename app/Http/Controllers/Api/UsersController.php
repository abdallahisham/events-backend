<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterUserRequest;
use App\Transformers\AccessTokenResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UsersRepository;

class UsersController extends Controller
{
    private $users;

    function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

    public function login(Request $request)
    {
        $response = $this->users->login($request->all());
        return new AccessTokenResponse($response, 200);
    }

    public function register(RegisterUserRequest $request)
    {
        $this->users->create($request->prepared());

        $response = $this->users->login($request->all());
        return new AccessTokenResponse($response, 200);
    }
}
