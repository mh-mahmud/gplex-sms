<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\File;
use Validator;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        var_dump(env('APP_DEBUG','false'));
//        if(env('APP_DEBUG')){
//        DB::listen(function(QueryExecuted $query) {
//            File::append(
//                storage_path('/logs/query.log'),
//                $query->sql . ' [' . implode(', ', $query->bindings) . ']' . '[' . $query->time . ']' . PHP_EOL
//            );
//        });
//        }

        //
        Validator::extend('test', function ($attribute, $value, $parameters, $validator) {
            return false;
        });

        Validator::replacer('test', function($message, $attribute, $rule, $parameters) {
            return "Test validator.";
        });
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
