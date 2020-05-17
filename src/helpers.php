<?php

if (!function_exists('create_disk')) {
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
    };
}
