<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\PostRepositoryInterface;
use App\Repositories\EloquentPostRepository;
use App\Contracts\Services\PostServiceInterface;
use App\Services\PostService;
use App\Contracts\Repositories\MediaRepositoryInterface;
use App\Repositories\EloquentMediaRepository;
use App\Contracts\Services\MediaServiceInterface;
use App\Services\MediaService;

class PostServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, EloquentPostRepository::class);
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(MediaRepositoryInterface::class, EloquentMediaRepository::class);
        $this->app->bind(MediaServiceInterface::class, MediaService::class);
    }

    public function boot(): void
    {
        //
    }
}
