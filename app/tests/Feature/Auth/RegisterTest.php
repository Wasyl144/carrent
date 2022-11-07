<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\FeatureBaseTest;

class RegisterTest extends FeatureBaseTest
{
    use WithFaker;

    protected string $endpoint = 'api/v1/register';

    public function testShouldRegisterAccountIfProvideValidData()
    {
        Artisan::call('config:cache');

        $dummyData = $this->getUserDummyData();

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->postJson($this->getEndpoint(), $dummyData)
            ->assertCreated()
            ->assertJsonStructure([
                'data',
                'success',
            ])->assertJsonPath('success', true);
    }

    public function testShouldRegisterAccountsIfProvideValidData()
    {
        Artisan::call('config:cache');

        $dummyData = $this->getUserDummyData();

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->postJson($this->getEndpoint(), $dummyData)
            ->assertCreated()
            ->assertJsonStructure([
                'data',
                'success',
            ])->assertJsonPath('success', true);

        $dummyData = $this->getUserDummyData();

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->postJson($this->getEndpoint(), $dummyData)
            ->assertCreated()
            ->assertJsonStructure([
                'data',
                'success',
            ])->assertJsonPath('success', true);
    }

    public function testShouldNotRegisterUserWhenProvideUnvalidatedData()
    {
        $dummyData = [
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'email' => 'mamamam',
            'password' => 'Example123.',
            'password_confirmation' => 'Example123.',
        ];

        $this->withHeaders(['Content-type' => 'Application/json'])
            ->postJson($this->getEndpoint(), $dummyData)
            ->assertUnprocessable()
            ->assertJsonPath('success', false);
    }
}
