<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\FeatureTestHelper;

class FeatureBaseTest extends TestCase
{
    use DatabaseMigrations, FeatureTestHelper;

    protected string $url = 'http://localhost/';

    protected string $endpoint;

    protected const USER_DEFAULT_PASSWORD = 'Example123.';
}
