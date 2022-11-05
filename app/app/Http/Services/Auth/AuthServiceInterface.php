<?php

namespace App\Http\Services\Auth;

interface AuthServiceInterface
{
    public function makeLogin();

    public function makeLogout();
}
