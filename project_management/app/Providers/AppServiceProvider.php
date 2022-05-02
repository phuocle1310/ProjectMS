<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
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
        //
        Paginator::useBootstrapFour();
        
        Validator::replacer('unique', function ($message, $attribute, $rule, $parameters) {
            if($attribute == 'userid')
                return str_replace(':other', 'project.', $message);
            if($attribute == 'projectid')
                return str_replace(':other', 'staff.', $message);
      });
    }
}
