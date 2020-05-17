<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Zahper routes
|--------------------------------------------------------------------------
|
| There are 2 routes created:
|
| [GET] /email/unsubscribe/{uuid}
| Used to trigger an event to unsubscribe an email recipient. There is no
| listener created, so it's up to you to create a listener for the event.
|
| [GET] /email/view/{uuid}
| Used to show the email in the browser, so you can have the "view in browser"
| functionality.
|
*/

Route::get('email/unsubscribe/{uuid}', 'ZahperController@unsubscribe');

Route::get('email/view/{uuid}', 'ZahperController@view');
