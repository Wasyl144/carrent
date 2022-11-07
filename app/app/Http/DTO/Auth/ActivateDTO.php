<?php

namespace App\Http\DTO\Auth;

use App\Http\DTO\DTOInterface;

class ActivateDTO implements DTOInterface
{
    public function __construct(
        private readonly string $token
    ) {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
