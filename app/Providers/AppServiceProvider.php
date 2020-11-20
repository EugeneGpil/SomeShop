<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('phone', function($attribute, $value, $parameters)
        {
            if ($value[0] != '+') {
                return false;
            }

            if (
                strpos($value, '.') !== false
                || strpos($value, 'e') !== false
                || strpos($value, '-') !== false
            ) {
                return false;
            }

            if (!is_numeric($value)) {
                return false;
            }

            return true;
        });
    }
}
