<?php

namespace App\Providers;

use App\Services\GitHub\Contracts\GithubApi;
use App\Services\GitHub\PhpGithubApi;
use Github\Client;
use Illuminate\Support\ServiceProvider;

class GithubServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(GithubApi::class, function ($app) {
            return new PhpGithubApi($app->make(Client::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
