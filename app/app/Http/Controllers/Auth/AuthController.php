<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Services\Auth\AuthServiceInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ResponseTrait;
    public function __construct(
        AuthServiceInterface $authService
    ) {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $dto = $request->getDto();
            dd($dto);
        } catch (\Exception $e){

        }

        return $this->responseSuccess([]);
    }

    public function logout(): Response
    {
        return \response()->noContent();
    }
}
