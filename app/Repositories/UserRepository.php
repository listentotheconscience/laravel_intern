<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function all()
    {
        return User::all();
    }

    public function getCurrentUser()
    {
        return Auth::user();
    }

    public function getCurrentUserId()
    {
        return Auth::id();
    }

    public function store($name, $email, $password, $avatar_path)
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'avatar' => $avatar_path
        ]);
    }
}
