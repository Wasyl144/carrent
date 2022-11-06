<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Tests\FeatureBaseTest;

class LoginTest extends FeatureBaseTest
{
    protected string $endpoint = 'api/v1/login';

    public function testShouldLoginUserIfCredentialsIsCorrect()
    {
        Artisan::call('config:cache');
        $user = $this->generateUser();

        if (! $this->checkIfPersonalAccessClientExists()) {
            $this->generateClient();
        }

        $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->postJson($this->getEndpoint(), [
            'email' => $user->email,
            'password' => self::USER_DEFAULT_PASSWORD,
        ])->assertStatus(Response::HTTP_OK);
    }

    public function testShouldNotLoginUserIfCredentialsIsIncorrect()
    {
        Artisan::call('config:cache');

        $user = $this->generateUser();

        if (! $this->checkIfPersonalAccessClientExists()) {
            $this->generateClient();
        }

        $this->withHeaders([
            'Content-Type' => 'application/json',
        ])->postJson($this->getEndpoint(), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
