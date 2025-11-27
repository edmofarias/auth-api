<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private IUserService $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function show($userId)
    {
        try {
            $user = $this->userService->show($userId);

            if ($user === null) {
                return response()->json(['error' => 'User not found or unauthorized'], 404);
            }

            return response()->json($user);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    public function update(Request $request, $userId)
    {
        try {
            $user = $this->userService->update($userId, $request->all());

            if ($user === null) {
                return response()->json(['error' => 'User not found or unauthorized'], 404);
            }

            return response()->json($user);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    public function delete($userId)
    {
        try {
            $user = $this->userService->delete($userId);

            if (!$user) {
                return response()->json(['error' => 'User not found or unauthorized'], 404);
            }

            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }
}
