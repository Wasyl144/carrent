<?php

namespace Tests\Feature\Auth;

use Illuminate\Support\Facades\Artisan;
use Tests\FeatureBaseTest;

class LogoutTest extends FeatureBaseTest
{
    protected string $endpoint = 'api/v1/logout';

    public function testShouldLogoutUserIfIsLoggedin()
    {
        Artisan::call('config:cache');
        $user = $this->generateUser();

        $accessToken = $this->getAccessToken($user);

        $this->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessToken",
        ])->post($this->getEndpoint())->assertNoContent();
    }
}
