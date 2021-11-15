<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        Relation::morphMap([
            'users' => User::class,
            'authors' => Author::class,
            'comments' => Comment::class
        ]);
    }
}
