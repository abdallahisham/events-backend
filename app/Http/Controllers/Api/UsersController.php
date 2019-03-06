<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterUserRequest;
use App\Transformers\AccessTokenResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepository;

class UsersController extends Controller
{
    private $users;

    public function __construct(UserRepository $users)
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
        $this->users->create($request->prepared());
        $response = $this->users->login($request->all());

        return new AccessTokenResponse($response, 200);
    }

    public function getProfile()
    {
        $id = auth()->id();
        $user = $this->users->find($id);

        return [
            'response' => [
                'httpCode' => 200,
                'name' => $user->name,
                'email' => str_contains($user->email, '@facebook') ? '' : $user->email,
                'mobile_number' => $user->mobile_number ?? '',
                'desc' => $user->desc ?? '',
            ],
        ];
    }

    public function updateProfile(Request $request)
    {
    }
}
