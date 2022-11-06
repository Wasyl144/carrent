<?php

namespace App\Http\Services\Auth\Logout;

use App\Models\User;

interface LogoutServiceInterface
{
    public function logout(User $user): void;
}
