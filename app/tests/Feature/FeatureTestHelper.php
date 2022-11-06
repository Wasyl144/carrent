<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\PersonalAccessClient;

trait FeatureTestHelper
{
    protected function getEndpoint(): string
    {
        return $this->url.$this->endpoint;
    }

    protected function checkIfPersonalAccessClientExists()
    {
        return PersonalAccessClient::whereHas('client', function ($q) {
            $q->where('revoked', 0);
        })->first();
    }

    protected function generateClient(): void
    {
        Artisan::call('passport:client', ['--personal' => true, '--no-interaction' => true]);
    }

    protected function generateUserWithoutVerifiedEmail(): User
    {
        return User::factory()->unverified()->create();
    }

    protected function generateUser(): User
    {
        return User::factory()->create();
    }

    protected function failedResponse(string $errorMessage, int $status): array
    {
        return ['error' => $errorMessage, 'error_code' => $status, 'success' => false];
    }

    protected function successResponse(array $data = []): array
    {
        return ['data' => $data, 'success' => true];
    }

    protected function getAccessToken(User $user): string
    {
        if (! $this->checkIfPersonalAccessClientExists()) {
            $this->generateClient();
        }

        return $this->withHeaders(['Content-Type'=>'application/json'])->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => self::USER_DEFAULT_PASSWORD,
        ])->json('data.access_token');
    }
}
