<?php

namespace App\Http\DTO\Auth;

use App\Http\DTO\DTOInterface;

class LoginDTO implements DTOInterface
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
