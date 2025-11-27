<?php

namespace App\Services;

use App\Models\User;
use App\Services\Contracts\IUserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService implements IUserService
{
    public function show(int $userId): ?User
    {
        if ($userId <= 0) {
            return null;
        }

        $user = User::find($userId);

        if ($user->id !== Auth::id()) {
            return null;
        }

        if ($user === null) {
            return null;
        }

        return $user;
    }

    public function update(int $userId, array $userData): ?User
    {
        if ($userId <= 0) {
            return null;
        }

        $user = User::find($userId);

        if ($user === null) {
            return null;
        }
        
        if ($user->id !== Auth::id()) {
            return null;
        }

        $validated = Validator::make($userData, [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255',
            'password' => 'sometimes|required|string|min:8|confirmed',
        ])->validate();

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return $user;
    }

    public function delete(int $userId): bool
    {
        if ($userId <= 0) {
            return false;
        }

        $user = User::find($userId);

        if ($user === null) {
            return false;
        }

        if ($user->id !== Auth::id()) {
            return false;
        }

        $user->delete();

        return true;
    }
}