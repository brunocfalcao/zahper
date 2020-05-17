<?php

namespace Brunocfalcao\Zahper\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ZahperController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:10,1');
    }

    /**
     * View in browser.
     *
     * @param  string $uuid [description]
     * @return [type]       [description]
     */
    public function view(string $uuid)
    {
        $filePath = config('zahper.storage.paths.emails').'/'.$uuid.'.html';

        // uuid html exists?
        if (File::exists($filePath)) {
            return response(file_get_contents($filePath), 200)
                   ->header('Content-Type', 'text/html');
        }
    }
}
