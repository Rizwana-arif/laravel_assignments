<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
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
   

public function boot()
{
    // if (!function_exists('str_limit')) {
    //     /**
    //      * Limit the number of words in a string.
    //      *
    //      * @param  string  $value
    //      * @param  int     $limit
    //      * @param  string  $end
    //      * @return string
    //      */
    //     function str_limit($value, $limit = 100, $end = '...')
    //     {
    //         return Str::limit($value, $limit, $end);
    //     }
    //     dd('str_limit is defined:', function_exists('str_limit'));
    // }
}

}
