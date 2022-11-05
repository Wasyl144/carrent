<?php

namespace App\Services\Auth;

interface AuthServiceInterface
{
    public function makeLogin();
    public function makeLogout();
}
