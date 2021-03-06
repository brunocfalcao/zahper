<?php

namespace Brunocfalcao\Zahper;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\View;

abstract class ZahperMailable extends Mailable
{
    public $zhp_uuid;

    public function __construct()
    {
        // Generates a unique uuid for this mailable.
        $this->zhp_uuid = ZahperTemplate::generateUuid();
    }

    public function build()
    {
        $template = ZahperTemplate::make($this->template(), $this->templateName());

        $template->renderAndStore($this->zhp_uuid, $this->buildViewData());

        $output = $this
            // This is the main html view that will use the html variable.
            ->view('zahper::'.$template->getName().'-html')
            // This is the main content view that will use the text variable.
            ->text('zahper::'.$template->getName().'-text');

        return $output;
    }

    protected function template()
    {
    }

    protected function templateName()
    {
    }
}
