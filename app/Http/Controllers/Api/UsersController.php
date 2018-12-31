<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterUserRequest;
use App\Transformers\AccessTokenResponse;
use App\Transformers\UserResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UsersRepository;

class UsersController extends Controller
{
    private $users;

    function __construct(UsersRepository $users)
    {
        $this->middleware('auth:api')->only(['getProfile', 'updateProfile']);
        $this->users = $users;
    }

    public function login(Request $request)
    {
        $response = $this->users->login($request->all());
        return new AccessTokenResponse($response, 200);
    }

    public function register(RegisterUserRequest $request)
    {
        logger()->info('Registering user...');
        $this->users->create($request->prepared());
        logger()->info($request->prepared()['desc']);
        $response = $this->users->login($request->all());
        return new AccessTokenResponse($response, 200);
    }

    public function getProfile()
    {
        logger()->info("Getting profile ...");
        $id = auth()->id();
        $user = $this->users->find($id);
        logger()->info($user->id);
        return [
            'response' => [
                'httpCode' => 200,
                'name' => $user->name,
                'email' => $user->email,
                'mobile_number' => $user->mobile_number,
                'desc' => $user->desc ?? ''
            ]
        ];
    }

    public function updateProfile(Request $request)
    {
        
    }
}
