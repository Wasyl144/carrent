<?php

namespace App\Http\DTO\Activation;

use App\Http\DTO\DTOInterface;

class RequestForActivationDTO implements DTOInterface
{
    public function __construct(
        private readonly string $email
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
