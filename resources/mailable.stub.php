<?php

namespace App\Mail;

use Brunocfalcao\Zahper\ZahperComponent;
use Brunocfalcao\Zahper\ZahperMailable;
use Brunocfalcao\Zahper\ZahperTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class classname extends ZahperMailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
        // --- Zahper code ---
        ZahperTemplate::$cache = false;
        parent::__construct();
        // --- /Zahper code ---
    }

    /**
     * Automatically generates a template name based on your namespace.
     * You can tweak it to generate any name you want.
     * Used for the cache template name for the views cache.
     *
     * @return string
     */
    protected function templateName()
    {
        return get_class($this);
    }

    /**
     * Zahper mjml template generator.
     * Here you construct your template, with the information you need.
     * Please check the zahper documentation in github to know how to create
     * that awesome MJML template!
     *
     * @return ZahperComponent
     */
    protected function template()
    {
        $mjml = ZahperComponent::make();

        $head = $mjml->with('mj-head');

        $body = $mjml->with('mj-body');

        return $mjml;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
            ->from(
                'you@example.com',
                'You from Example.com'
            )
            ->subject('Nice subject out here!');

        parent::build();
    }
}
