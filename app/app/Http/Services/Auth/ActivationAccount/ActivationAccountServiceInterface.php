<?php

namespace App\Http\Services\Auth\ActivationAccount;

use App\Http\DTO\DTOInterface;
use App\Models\User;

interface ActivationAccountServiceInterface
{
    public function activateAccount(DTOInterface $dto): void;

    public function sendActivationEmail(User $user): void;

    public function getActivationLinkByUser(User $user): string;

    public function createActivationToken(User $user): void;

    public function checkIsVerifiedUser(User $user): void;

    public function revokeTokensByEmail(string $email): void;
}
