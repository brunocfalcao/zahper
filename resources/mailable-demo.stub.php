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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Please see ZahperTemplate.php to understand the impacts!
        ZahperTemplate::$cache = false;
        parent::__construct();
    }

    /**
     * Automatically generates a template name based on your namespace.
     * You can tweak it to generate any name you want.
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

        $head->with('mj-preview', 'Zahper Demo')
                ->parent()
             ->with('mj-style', ".text-link { color: #FFFFFF }")
                ->inline('inline')
                ->parent()
             ->with('mj-font')
                ->name('Nunito')
                ->href('https://fonts.googleapis.com/css?family=Nunito')
                ->parent()
             ->with('mj-attributes')
                ->with('mj-all')
                    ->fontFamily('Nunito')
                    ->fontSize('0.90rem')
                    ->letterSpacing('0.04rem')
                    ->lineHeight('1.5rem')
                    ->padding('0px');

        $body = $mjml->with('mj-body')
                        ->backgroundColor('#2d3748')
                        ->width('800px')
                        ->with('mj-section')
                            ->with('mj-column')
                                ->with('mj-spacer')
                                    ->height('50px')
                                    ->parent()
                                ->parent()
                            ->parent()
                        ->with('mj-section')
                            ->with('mj-column')
                                ->backgroundColor('#ED8936')
                                ->with('mj-text', '&#8212;&#8212;&nbsp;Zahper')
                                    ->letterSpacing('0px')
                                    ->align('right')
                                    ->paddingRight('50px')
                                    ->paddingTop('25px')
                                    ->paddingBottom('25px')
                                    ->fontSize('25px')
                                    ->color('#FFFFFF')
                                    ->parent()
                                ->parent()
                            ->parent()
                        ->with('mj-section')
                            ->padding('40px')
                            ->backgroundColor('#FFFFFF')
                                ->with('mj-column')
                                    ->with('mj-text', 'Hi there!')
                                        ->align('center')
                                        ->color('#1A202C')
                                        ->fontSize('20px')

                                            ;



        /*
        $body->with('mj-section')
                ->with('mj-column')
                    ->with('mj-text', 'Hi {{ $zhp_uuid }}!');
        */

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
