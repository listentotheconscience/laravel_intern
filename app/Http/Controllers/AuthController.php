<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

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

        $this->repository->store(
            $request->name,
            $request->email,
            $request->password,
            $path
        );

        return redirect('/email/verify');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/login');
    }

    public function verification(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/');
    }

    public function sendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return redirect('/');
    }
}
