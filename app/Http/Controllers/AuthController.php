<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{
    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/posts');
        }

        return redirect('/login');
    }

    public function register(AuthRegisterRequest $request)
    {
        $path = $request->image->store('images');

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => $path
        ]);

        return redirect('/login');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/login');
    }
}
