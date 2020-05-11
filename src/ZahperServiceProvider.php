<?php

namespace Brunocfalcao\Zahper;

use Illuminate\Support\ServiceProvider;

class ZahperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register zahper disks.
        create_disk('zahper-views', app('config')->get('zahper.storage.paths.views'));
        create_disk('zahper-browser', app('config')->get('zahper.storage.paths.browser'));

        // Register views, in order to be used by the Zahper Mailable.
        $this->loadViewsFrom(app('config')->get('zahper.storage.paths.views'), 'zahper');
    }

    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/zahper.php', 'zahper');
    }
}
