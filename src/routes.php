<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Zahper routes
|--------------------------------------------------------------------------
|
| There are 2 routes that Zahper creates:
|
| [GET] zahper/view/{uuid}
| Used to show the email in the browser, so you can have the "view in browser"
| functionality.
|
| [GET] zahper/unsubscribe/{uuid}
| Used to unsubscribe a newsletter. The default controller
|
*/

Route::get(
    config('zahper.routes.view-in-browser.route'),
    config('zahper.routes.view-in-browser.action')
)->name('zahper.view-in-browser');

Route::get(
    config('zahper.routes.unsubscribe.route'),
    config('zahper.routes.unsubscribe.action')
)->name('zahper.unsubscribe');

if (config('zahper.demo')) {
    Route::get('zahper/demo', 'ZahperController@demo')
         ->name('zahper.demo');
}
