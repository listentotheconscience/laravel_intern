<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function profile()
    {
        $user = $this->repository->getCurrentUser();

        return view('profile')->with('title', $user->name)->with('user', $user);
    }

    public function apiProfile()
    {
        $user = $this->repository->getCurrentUser();

        return $this->sendResponse(new UserResource($user), 'OK');
    }
}
