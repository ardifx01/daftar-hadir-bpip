<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Classes\AuthSSO;
use Illuminate\Support\Facades\Blade;

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
        Blade::if('login', function () {

            return AuthSSO::getSessionToken();
        });

        //if (env("FORCE_SSL"))
            \URL::forceScheme('https');
    }
}
