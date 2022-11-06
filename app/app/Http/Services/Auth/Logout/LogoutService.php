<?php

namespace App\Http\Services\Auth\Logout;

use App\Models\User;

class LogoutService implements LogoutServiceInterface
{
    public function logout(User $user): void
    {
        $token = $user->token();
        $token->revoke();
    }
}
