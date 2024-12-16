<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserServiceImpl implements UserService
{

   

    function login(string $email, string $password): bool
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password
        ]);
    }

    function register ( $user) {
         if(User::create([
            'name' => $user['username'],
            'email' => $user['email'],
            'password' => Hash::make($user['password'])
        ])) {
            return true;
        }

        return false;
    }
}
