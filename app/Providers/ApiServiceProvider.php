<?php

namespace App\Providers;

use App\ApiClient;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ApiClient::class, function ($app) {
            $config = config('services.oauth');
            return new ApiClient($config);
        });
    }
}
