<?php

namespace App\Http\Services\Auth\Login;

use App\Exceptions\UserNotFoundException;
use App\Http\DTO\Auth\LoginDTO;
use App\Http\DTO\DTOInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LoginService implements LoginServiceInterface
{
    private Authenticatable $user;

    public function checkCredentials(LoginDTO|DTOInterface $dto): void
    {
        if (! Auth::attempt(['email' => $dto->getEmail(), 'password' => $dto->getPassword()])) {
            throw new UserNotFoundException();
        }

        $this->user = Auth::user();
    }

    public function getUser(): Authenticatable
    {
        return $this->user;
    }

    public function getToken(): string
    {
        return $this->user->createToken(Str::random(), $this->user->getPermissionsNamesAsArray())->accessToken;
    }
}
