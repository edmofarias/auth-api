<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IAuthService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        try {
            $token = $this->authService->register($request->all());

            return response()->json(data: [
                'message' => 'User successfully registered',
                'token' => $token,
            ]);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $result = $this->authService->login($request->all());

            if ($result === null) {
                return response()->json('Invalid credentials', Response::HTTP_UNAUTHORIZED);
            }

            return response()->json($result);
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (Exception $e) {
            return $this->responseError($e->getMessage());
        }

        return response()->json(data: [
            'message' => 'User successfully logged out'
        ]);
    }
}
