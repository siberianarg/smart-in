<?php

namespace App\Providers;

use App\Client\MoySkladClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
{
    $this->app->singleton(MoySkladClient::class, function ($app) {
        return new MoySkladClient(
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
