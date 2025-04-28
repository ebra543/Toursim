<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class GeoapifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('geoapify', function ($app) {
            return new \App\Services\GeoapifyService(
                new Client(),
                config('app.geoapify.map_tiles'),
                config('app.geoapify.geocoding'),
                config('app.geoapify.routing'),
                config('app.geoapify.places')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}