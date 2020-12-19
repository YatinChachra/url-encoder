<?php

namespace App\Providers;

use App\Encrypter\UrlEncrypter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register Facades
        $this->app->bind('url-encrypt', function () {
            return new UrlEncrypter();
        });
    }
}
