<?php

namespace App\Providers;

use App\Client\MSClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
{
    $this->app->singleton(MSClient::class, function ($app) {
        return new MSClient(
            config('services.moysklad.token'),
            config('services.moysklad.accountId')
        );
    });
}

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
