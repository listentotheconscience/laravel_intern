<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function profile()
    {
        $user = Auth::user();
        return view('profile')->with('title', $user->name)->with('user', $user);
    }

    public function apiProfile()
    {
        $user = Auth::user();

        return $this->sendResponse(new UserResource($user), 'OK');
    }
}
