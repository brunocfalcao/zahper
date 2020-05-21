<?php

if (! function_exists('create_disk')) {
    function create_disk($name, $path, $driver = 'local')
    {
        app('config')->set(
            'filesystems.disks',
            array_merge(
                [
                    $name => [
                        'driver' => $driver,
                        'root' => $path,
                    ],
                ],
                app('config')->get('filesystems.disks')
            )
        );
    }
}

if (! function_exists('zhp_url_unsubscribe()')) {
    function zhp_url_unsubscribe($uuid)
    {
        return route('zahper.unsubscribe', ['uuid' => $uuid]);
    }
}

if (! function_exists('zhp_url_view_in_browser()')) {
    function zhp_url_view_in_browser($uuid)
    {
        return route('zahper.view-in-browser', ['uuid' => $uuid]);
    }
}
