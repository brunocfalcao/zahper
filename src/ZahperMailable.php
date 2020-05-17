<?php

namespace Brunocfalcao\Zahper;

use Illuminate\Mail\Mailable;

class ZahperMailable extends Mailable
{
    public function __construct()
    {
    }

    public function build()
    {
        $template = ZahperTemplate::make($this->template(), $this->templateName());

        $output = $this
            // This is the main html view that will use the html variable.
            ->view('zahper::'.$template->getName().'-html')
            // This is the main html view that will use the text variable.
            ->text('zahper::'.$template->getName().'-html');

        return $output;
    }
}
