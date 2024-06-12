<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
 use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       

    Validator::extend('not_in_past', function ($attribute, $value, $parameters, $validator) {
        return strtotime($value) >= strtotime(date('Y-m-d'));
    });

    }
}
