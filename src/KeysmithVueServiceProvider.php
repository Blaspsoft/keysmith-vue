<?php

namespace Modla\KeysmithVue;

use Illuminate\Support\Facades\Route;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Modla\KeysmithVue\Contracts\TokenController;
class KeysmithVueServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if(file_exists(app_path('Http/Controllers/APITokens/TokenController.php'))) {
            // Register routes based on which controller implementation exists in the app
            Route::middleware(['web', 'auth'])
                ->group(function () {
                    require __DIR__.'/../routes/web.php';
                });
        }

        if(file_exists(app_path('Http/Controllers/Settings/TokenController.php'))) {    
            // Register routes based on which controller implementation exists in the app
            Route::middleware(['web', 'auth'])
                ->group(function () {
                    require __DIR__.'/../routes/settings.php';
                });
        }

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('keysmith.php'),
            ], 'config');
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $filesystem = new Filesystem();

        // Dynamically bind the correct controller based on its presence
        $controllers = [
            'App\Http\Controllers\APITokens\TokenController' => app_path('Http/Controllers/APITokens/TokenController.php'),
            'App\Http\Controllers\Settings\TokenController' => app_path('Http/Controllers/Settings/TokenController.php'),
        ];

        foreach ($controllers as $class => $path) {
            if ($filesystem->exists($path)) {
                $this->app->bind($class);
                break;
            }
        }
        
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'keysmith');

        return [Console\InstallCommand::class];
    }
}
