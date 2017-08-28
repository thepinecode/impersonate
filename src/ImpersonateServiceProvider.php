<?php

namespace Pine\Impersonate;

use Illuminate\Support\ServiceProvider;

class ImpersonateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(dirname(__DIR__).'/routes/web.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
