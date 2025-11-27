<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\IAuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements IAuthService
{
    public function register(array $userData): string
    {
        $validated = Validator::make($userData, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ])->validate();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return $token;
    }

    public function login(array $userData): array|null
    {
        $validated = Validator::make($userData, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ])->validate();

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return null;
        }

        $token = JWTAuth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        if (!$token) {
            return null;
        }

        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer'
        ];
    }
}