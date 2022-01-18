<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\Tools;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('tools',function(){
            return new Tools;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       //
    }
}
