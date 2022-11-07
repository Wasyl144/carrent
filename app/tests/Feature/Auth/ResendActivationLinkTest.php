<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Artisan;
use Tests\FeatureBaseTest;

class ResendActivationLinkTest extends FeatureBaseTest
{
    protected string $endpoint = 'api/v1/resend-activation-link';

    public function testShouldResendActivateLinkIfUserIsNotVerified()
    {
        Artisan::call('config:cache');

        $userNotActivated = $this->generateUserWithoutVerifiedEmail();

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->postJson($this->getEndpoint(), ['email' => $userNotActivated->email])
            ->assertOk()
            ->assertJsonPath('data.message', 'New link has been sent.')
            ->assertJsonPath('success', true);
    }

    public function testShouldNotResendActivateLinkIfUserIsVerified()
    {
        Artisan::call('config:cache');

        $userActivated = $this->generateUser();

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->postJson($this->getEndpoint(), ['email' => $userActivated->email])
            ->assertUnprocessable()
            ->assertJsonPath('error', 'User with assigned email has been activated before.')
            ->assertJsonPath('success', false);
    }

    public function testShouldNotResendActivateLinkIfUserNotExists()
    {
        Artisan::call('config:cache');

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->postJson($this->getEndpoint(), ['email' => 'dummy@example.com'])
            ->assertUnprocessable()
            ->assertJsonPath('success', false);
    }
}
