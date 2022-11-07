<?php

namespace App\Http\Services\Auth\Register;

use App\Exceptions\TokenNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Http\DTO\Auth\ActivateDTO;
use App\Http\DTO\DTOInterface;
use App\Http\DTO\Register\RegisterDTO;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterService implements RegisterServiceInterface
{
    public function createUser(DTOInterface|RegisterDTO $dto): User
    {
        return User::query()->create([
            'name' => $dto->getName(),
            'last_name' => $dto->getLastName(),
            'email' => $dto->getEmail(),
            'password' => bcrypt($dto->getPassword()),
            'phone_number' => $dto->getPhoneNumber(),
        ]);
    }
}
