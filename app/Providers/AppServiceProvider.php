<?php

namespace App\Providers;

use Illuminate\Support\Str;
use  Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        Str::macro('currency', function ($price){
            return number_format($price, 2, '.', '\'');
        });

    }
}
