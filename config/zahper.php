<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MJML API configuration
    |--------------------------------------------------------------------------
    |
    | In order to compile your MJML you need to first request a MJML API
    | authentication credentials.
    | Go to https://mjml.io/api and follow the steps.
    | Then populate your .env file with those keys and your received
    | credentials.
    |
    */

    'api' => [

        'url' => env('ZAHPER_API_URL', 'https://api.mjml.io/v1/render'),
        'application_id' => env('ZAHPER_API_APPLICATION_ID', ''),
        'secret_key' => env('ZAHPER_API_SECRET_KEY', ''),
    ],

    'images' => [

        /*
        |--------------------------------------------------------------------------
        | Images rendering
        |--------------------------------------------------------------------------
        |
        | You can choose image rendering types:
        | 'cid' -> Will convert your url into a CID attachment.
        | '' (blank) -> Will use the url your passed.
        |
        | E.g.:
        | ->with('mj-image')
        |   ->href('http://www.example.com/image.jpg')
        |
        | If you are using 'cid', then this url will be converted using the CID
        | attachment, as explained here: https://laravel.com/docs/7.x/mail#inline-attachments
        |
        */

        'render' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage paths
    |--------------------------------------------------------------------------
    |
    | There are 2 storage paths that zahper need:
    | 'views' : Where zahper will make a cache of your mjml compilation. This
    | is the case that when you send 500 emails, you don't want to make 500
    | mjml compilations to html, but just one. Then zahper uses the cache for
    | the next 499. Please check ZahperTempate.php for more information on this.
    |
    | 'browser' : This is where a uuid html is saved with an exact copy of the
    | email that was sent. You can use this uuid to generate a "view in browser"
    | or a "unsubscribe". Both use the same uuid.
    |
    | REMARK: This uuid is not saved in a database, so you can only use it in the
    | moment that zahper generates the html.
    |
    */

    'storage' => [
        'paths' => [
            // Repository for the compiled HTML to be used in the mailable views.
            'views' => storage_path('app/zahper/cache'),

            // Repository for the "view in browser" rendered emails. They will
            // have a uuid that is connected to the uuid that was sent in the
            // email.
            'browser' => storage_path('app/zahper/emails'),
        ],
    ],
];
