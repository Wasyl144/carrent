<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Services\Auth\Login\LoginServiceInterface;
use App\Http\Services\Auth\Logout\LogoutServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        private LoginServiceInterface $loginService,
        private LogoutServiceInterface $logoutService
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $dto = $request->getDto();
        $this->loginService->checkCredentials($dto);
        $token = $this->loginService->getToken();
        $user = $this->loginService->getUser();

        return $this->responseSuccess([
            'access_token' => $token,
            'user_id' => $user->id,
        ]);
    }

    public function logout(LogoutRequest $request): Response
    {
        $this->logoutService->logout($request->user());

        return \response()->noContent();
    }
}
