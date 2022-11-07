<?php

namespace App\Providers;

use App\Http\Services\Auth\ActivationAccount\ActivationAccountService;
use App\Http\Services\Auth\ActivationAccount\ActivationAccountServiceInterface;
use App\Http\Services\Auth\Login\LoginService;
use App\Http\Services\Auth\Login\LoginServiceInterface;
use App\Http\Services\Auth\Logout\LogoutService;
use App\Http\Services\Auth\Logout\LogoutServiceInterface;
use App\Http\Services\Auth\Register\RegisterService;
use App\Http\Services\Auth\Register\RegisterServiceInterface;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->app->bind(LoginServiceInterface::class, fn ($app) => new LoginService());
        $this->app->bind(LogoutServiceInterface::class, fn ($app) => new LogoutService());
        $this->app->bind(RegisterServiceInterface::class, fn ($app) => new RegisterService());
        $this->app->bind(ActivationAccountServiceInterface::class, fn ($app) => new ActivationAccountService());
    }
}
