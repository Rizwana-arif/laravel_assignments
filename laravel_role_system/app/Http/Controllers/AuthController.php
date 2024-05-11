<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $userCreate = User::create($request->validated());
        return response($userCreate);
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'Invalid Credentials'
            ]);
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;

        return response([
            'jwt' => $token
        ]);
    }
}
