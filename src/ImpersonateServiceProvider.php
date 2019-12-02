<?php

namespace Pine\Impersonate;

use Illuminate\Support\Facades\Blade;
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
        // Load the extra routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Publish the configuration file
        $this->publishes([
            __DIR__.'/../config/impersonate.php' => config_path('impersonate.php'),
        ]);

        // Register the @impersonate directive
        Blade::directive('impersonate', function () {
            return "<?php if(Session::has('original_user')): ?>";
        });

        // Register the @endimpersonate directive
        Blade::directive('endimpersonate', function () {
            return "<?php endif; ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Merge the config
        $this->mergeConfigFrom(
            __DIR__.'/../config/impersonate.php', 'impersonate'
        );
    }
}
