<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        AuthServiceInterface $authService
    )
    {
    }

    public function login()
    {

    }

    public function logout()
    {

    }
}
