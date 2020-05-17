<?php

namespace Brunocfalcao\Zahper;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ZahperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register zahper disks.
        create_disk('zahper-views', app('config')->get('zahper.storage.paths.views'));
        create_disk('zahper-browser', app('config')->get('zahper.storage.paths.emails'));

        // Register views, in order to be used by the Zahper Mailable.
        $this->loadViewsFrom(app('config')->get('zahper.storage.paths.views'), 'zahper');

        $this->registerCommands();

        $this->loadRoutes();

        $this->publishConfiguration();
    }

    public function loadRoutes()
    {
        Route::middleware('web')
             ->namespace('\Brunocfalcao\Zahper\Http\Controllers')
             ->group(function () {
                include(__DIR__.'/routes.php');
             });
    }

    public function register()
    {
    }

    protected function publishConfiguration()
    {
        $this->publishes([
        __DIR__.'/../config/zahper.php' => config_path('zahper.php'),
        ], 'zahper-config');
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                    ZahperCreateMailableCommand::class,
                ]);
        }
    }
}
