<?php

namespace App\Http\Services\Auth\Register;

use App\Http\DTO\DTOInterface;
use App\Models\User;

interface RegisterServiceInterface
{
    public function createUser(DTOInterface $dto): User;
}
