<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema; // fix boot()
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
        // Fix para MariaDB ao rodar migrations
        Schema::defaultStringLength(191);
        
        // força https na produção
        if (env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
