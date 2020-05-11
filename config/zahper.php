<?php

return [

    'api' => [

        'url' => env('ZAHPER_API_URL', ''),
        'application_id' => env('ZAHPER_API_APPLICATION_ID', ''),
        'secret_key' => env('ZAHPER_API_SECRET_KEY', ''),
    ],

    'images' => [

        /**
         * Defines the way an image can be rendered from the attributes
         * that are 'src'. E.g.: ->attribute('src', 'https://[...]').
         *
         * cid: The value will be converted into a {{ $message->embed('..') }}.
         * <other>: No conversion.
         *
         */
        'render' => ''
    ],

    'storage' => [
        'paths' => [
            // Repository for the compiled HTML to be used in the mailable views.
            'views' => storage_path('app/zahper'),

            // Repository for the "view in browser" rendered emails. They will
            // have a uuid that is connected to the uuid that was sent in the
            // email.
            'browser' => storage_path('app/zahper'),
        ]
    ],
];
