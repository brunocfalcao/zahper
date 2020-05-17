<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Zahper routes
|--------------------------------------------------------------------------
|
| There is only one route create:
|
| [GET] /email/view/{uuid}
| Used to show the email in the browser, so you can have the "view in browser"
| functionality.
|
*/

Route::get('email/view/{uuid}', 'ZahperController@view');
