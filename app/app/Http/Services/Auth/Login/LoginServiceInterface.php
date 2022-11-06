<?php

namespace App\Http\Services\Auth\Login;

use App\Http\DTO\DTOInterface;
use Illuminate\Contracts\Auth\Authenticatable;

interface LoginServiceInterface
{
    public function checkCredentials(DTOInterface $dto): void;

    public function getToken(): string;

    public function getUser(): Authenticatable;
}
