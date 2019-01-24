<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepository;

class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->findWhere([['email', '!=', 'admin@falyat.com']])->all();
        return view('admin.users.index', compact('users'));
    }

    public function destroy(int $id)
    {
        $this->userRepository->delete($id);
        flash(__('general.deleted'))->success();
        return back();
    }
}
