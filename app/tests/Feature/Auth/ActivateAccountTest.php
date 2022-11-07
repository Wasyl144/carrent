<?php

namespace Tests\Feature\Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\FeatureBaseTest;

class ActivateAccountTest extends FeatureBaseTest
{
    protected string $endpoint = 'api/v1/activate-account';

    public function testShouldActivateAccountIfIsRegistered()
    {
        Artisan::call('config:cache');

        $dummyData = $this->getUserDummyData();

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->postJson('api/v1/register', $dummyData)
            ->assertCreated();

        $token = $this->getTokenByMail($dummyData['email']);

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->call('GET', $this->getEndpoint(), ['token' => $token])
            ->assertOk()
            ->assertJsonPath('data.message', 'Account has been activated.')
            ->assertJsonPath('success', true);
    }

    public function testShouldNotActivateAccountIfTokenIsExpired()
    {
        Artisan::call('config:cache');

        $dummyData = $this->getUserDummyData();

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->postJson('api/v1/register', $dummyData)
            ->assertCreated();

        $token = $this->getTokenByMail($dummyData['email']);
        $this->expireToken($token);

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->call('GET', $this->getEndpoint(), ['token' => $token])
            ->assertNotFound()
            ->assertJsonPath('error', 'Token is not found or Will be expired.')
            ->assertJsonPath('success', false);
    }

    public function testShouldNotActivateUserIfTokenAreWrong()
    {
        Artisan::call('config:cache');

        $dummyToken = Str::random(64);

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->call('GET', $this->getEndpoint(), ['token' => $dummyToken])
            ->assertUnprocessable()
            ->assertJsonPath('success', false);
    }

    public function getTokenByMail(string $email): string
    {
        return DB::table('email_verification')
            ->where('email', '=', $email)
            ->where('expires', '>', Carbon::now())
            ->orderBy('created_at')
            ->first()->token;
    }

    private function expireToken(string $token)
    {
        DB::table('email_verification')
            ->where('token', '=', $token)
            ->update(['expires' => Carbon::createFromDate(2020)]);
    }
}
