<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Zahper demo route
    |--------------------------------------------------------------------------
    |
    | Want to see zahper in action in a demo?
    | Just write the command:
    | php artisan zahper:mailable ZahperDemo --demo
    |
    | Then open the browser and go to url:
    | <your-host>/zahper/demo
    |
    | Enjoy :)
    */

    'demo' => true,

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
        | attachment, as explained here:
        | https://laravel.com/docs/7.x/mail#inline-attachments
        |
        */

        'render' => '',
    ],

    /*
    |--------------------------------------------------------------------------
    | Zahper routes
    |--------------------------------------------------------------------------
    |
    | You can use 2 pre-defined routes to view an email in browser and to
    | unsubscribe. There are 2 helpers that you can use them in your views:
    |
    | zhp_url_view_in_browser()
    | zhp_url_unsubscribe()
    |
    | Example:
    | [..]->with('mj-button', 'Click here to unsubscribe')
    |         ->href("{{ zhp_url_unsubscribe() }}")
    |
    */
    'routes' => [

        'view-in-browser' => [
            'route' => 'zahper/view/{uuid}',
            'action' => 'ZahperController@view',
        ],

        'unsubscribe' => [
            'route' => 'zahper/unsubscribe/{uuid}',
            'action' => 'ZahperController@unsubscribe',
        ],
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
    | uuid.
    |
    | REMARK: This uuid is not saved in a database, so you can only use it in the
    | moment that zahper generates the html.
    |
    */

    'storage' => [
        'paths' => [
            // Repository for the compiled views to be used in the mailable cache.
            'views' => storage_path('app/zahper/views'),

            // Repository for the "view in browser" rendered emails. They will
            // have a uuid that is connected to the uuid that was sent in the
            // email.
            'emails' => storage_path('app/zahper/emails'),
        ],
    ],
];
