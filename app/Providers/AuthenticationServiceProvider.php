<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Repositories\EloquentUserRepository;
use App\Contracts\Repositories\RoleRepositoryInterface;
use App\Repositories\EloquentRoleRepository;
use App\Contracts\Services\AuthServiceInterface;
use App\Services\AuthService;
use App\Contracts\Services\UserServiceInterface;
use App\Services\UserService;
use App\Contracts\Services\TokenServiceInterface;
use App\Services\TokenService;
use App\Contracts\Services\ResetPasswordServiceInterface;
use App\Services\ResetPasswordService;

class AuthenticationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, EloquentRoleRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(TokenServiceInterface::class, TokenService::class);
        $this->app->bind(ResetPasswordServiceInterface::class, ResetPasswordService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
