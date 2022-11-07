<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActivateAccountRequest;
use App\Http\Requests\Auth\RequestActivationRequest;
use App\Http\Services\Auth\ActivationAccount\ActivationAccountServiceInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ActivationController extends Controller
{
    public function __construct(
        private ActivationAccountServiceInterface $activateAccountService,
    ) {
    }

    public function activateAccount(ActivateAccountRequest $request): JsonResponse
    {
        $dto = $request->getDto();
        $this->activateAccountService->activateAccount($dto);

        return $this->responseSuccess([
            'message' => 'Account has been activated.',
        ]);
    }

    public function resendActivationEmail(RequestActivationRequest $request): JsonResponse
    {
        $dto = $request->getDto();
        $user = User::query()->where('email', '=', $dto->getEmail())->first();
        $this->activateAccountService->checkIsVerifiedUser($user);
        $this->activateAccountService->revokeTokensByEmail($user->email);
        $this->activateAccountService->sendActivationEmail($user);

        return $this->responseSuccess([
            'message' => 'New link has been send',
        ]);
    }
}
