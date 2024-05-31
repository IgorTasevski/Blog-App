<?php

namespace App\Providers;

use App\Repositories\Comment\CommentRepository;
use App\Repositories\Interfaces\Comment\CommentRepositoryInterface;
use App\Repositories\Interfaces\Post\PostRepositoryInterface;
use App\Repositories\Interfaces\Tag\TagRepositoryInterface;
use App\Repositories\Interfaces\User\UserLoginInterface;
use App\Repositories\Interfaces\User\UserRegisterInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Tag\TagRepository;
use App\Repositories\User\UserLoginRepository;
use App\Repositories\User\UserRegisterRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(UserRegisterInterface::class, UserRegisterRepository::class);
        $this->app->bind(UserLoginInterface::class, UserLoginRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
