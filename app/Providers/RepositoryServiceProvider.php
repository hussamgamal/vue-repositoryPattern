<?php

namespace App\Providers;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\BaseRepositoryInterface;
use App\Http\Repositories\Interfaces\PostRepositoryInterface;
use App\Http\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
