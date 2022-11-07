<?php

namespace App\Http\Services\Auth\ActivationAccount;

use App\Exceptions\TokenNotFoundException;
use App\Exceptions\UserHasBeenActivatedException;
use App\Exceptions\UserNotFoundException;
use App\Http\DTO\Auth\ActivateDTO;
use App\Http\DTO\DTOInterface;
use App\Jobs\Auth\SendWelcomeEmailJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActivationAccountService implements ActivationAccountServiceInterface
{
    public function activateAccount(DTOInterface|ActivateDTO $dto): void
    {
        $token = DB::table('email_verification')
            ->where('token', '=', $dto->getToken())
            ->where('expires', '>', Carbon::now())
            ->first();

        if (! $token) {
            throw new TokenNotFoundException();
        }

        $user = User::query()->where('email', '=', $token->email)->first();
        if (! $user) {
            throw new UserNotFoundException();
        }
        $user->markEmailAsVerified();
        $this->revokeTokensByEmail($user->email);
    }

    public function sendActivationEmail(User $user): void
    {
        $data = [
            'name' => $user->full_name,
            'link' => $this->getActivationLinkByUser($user),
        ];

        SendWelcomeEmailJob::dispatch($user, $data)->onQueue(null);
    }

    public function createActivationToken(User $user): void
    {
        $token = Str::random(64);
        DB::table('email_verification')->insert(
            ['email' => $user->email, 'token' => $token, 'created_at' => Carbon::now(), 'expires' => Carbon::now()->addMinutes(20)]
        );
    }

    public function getActivationLinkByUser(User $user): string
    {
        $token = DB::table('email_verification')
            ->where('email', '=', $user->email)
            ->where('expires', '>', Carbon::now())
            ->orderBy('created_at')
            ->first();

        $link = route('auth.activate_account', ['token' => $token->token]);

        return $link;
    }

    public function checkIsVerifiedUser(User $user): void
    {
        if (! $user->hasVerifiedEmail()) {
            return;
        }

        throw new UserHasBeenActivatedException();
    }

    public function revokeTokensByEmail(string $email): void
    {
        DB::table('email_verification')
            ->where('email', '=', $email)
            ->delete();
    }
}
