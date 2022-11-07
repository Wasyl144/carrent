<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActivateAccountRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisteredUserResource;
use App\Http\Services\Auth\ActivationAccount\ActivationAccountService;
use App\Http\Services\Auth\ActivationAccount\ActivationAccountServiceInterface;
use App\Http\Services\Auth\Register\RegisterServiceInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __construct(
        private RegisterServiceInterface $registerService,
        private ActivationAccountServiceInterface $activationAccountService,
    ) {
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        $dto = $request->getDto();
        $user = $this->registerService->createUser($dto);
        $this->activationAccountService->createActivationToken($user);
        event(new Registered($user));

        return $this->responseSuccess([
            'message' => 'User has been created, check your email to activate Account.',
            'user' => RegisteredUserResource::make($user),
        ], Response::HTTP_CREATED);
    }
}
