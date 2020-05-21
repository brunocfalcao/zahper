<?php

namespace Brunocfalcao\Zahper\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ZahperDemoMailable;
use Brunocfalcao\Zahper\ZahperUnsubscribeEvent;
use Illuminate\Support\Facades\File;

class ZahperController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:10,1');
    }

    public function demo()
    {
        return new ZahperDemoMailable();
    }

    /**
     * View in browser.
     *
     * @param  string $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function view(string $uuid)
    {
        $filePath = config('zahper.storage.paths.emails').'/'.$uuid.'.html';

        // uuid html exists?
        if (File::exists($filePath)) {
            return response(file_get_contents($filePath), 200)
                   ->header('Content-Type', 'text/html');
        }

        return response('No UUID found.', 200);
    }

    /**
     * Unsubscribe your email related uuid.
     * Only this is to trigger an event, that you should have a listener
     * attached to. If you want to use your own logic feel free to change
     * the zahper.php config file.
     *
     * @param  string $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(string $uuid)
    {
        event(new ZahperUnsubscribeEvent($uuid));

        return response('Thank you, you have been unsubscribed!', 200);
    }
}
