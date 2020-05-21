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

        $head->with('mj-preview', 'Zahper Demo');
        $head->with('mj-style', '.text-link { color: #FFFFFF }');
        $head->with('mj-font')
                ->name('Nunito')
                ->href('https://fonts.googleapis.com/css?family=Nunito');

        $head->with('mj-attributes')
                ->with('mj-all')
                    ->fontFamily('Nunito')
                    ->fontSize('0.90rem')
                    ->letterSpacing('0.04rem')
                    ->lineHeight('1.5rem')
                    ->padding('0px');

        $body = $mjml->with('mj-body')
                        ->backgroundColor('#2d3748')
                        ->width('800px');

        // Header spacer.
        $body->with('mj-section')
                ->with('mj-column')
                    ->with('mj-spacer')
                        ->height('50px');

        // Zahper header.
        $body->with('mj-section')
                ->with('mj-column')
                    ->backgroundColor('#ED8936')
                        ->with('mj-text', '&#8212;&#8212;&nbsp;Zahper')
                            ->letterSpacing('0px')
                            ->align('right')
                            ->paddingRight('50px')
                            ->paddingTop('25px')
                            ->paddingBottom('25px')
                            ->fontSize('25px')
                            ->color('#FFFFFF');

        // Hi there.
        $body->with('mj-section')
                ->padding('40px')
                ->backgroundColor('#FFFFFF')
                    ->with('mj-column')
                        ->with('mj-text', 'Hi there!')
                            ->align('center')
                            ->color('#1A202C')
                            ->fontSize('20px');

        // Welcome to Zahper.
        $body->with('mj-section')
                ->paddingLeft('20px')
                ->paddingRight('20px')
                ->backgroundColor('#FFFFFF')
                    ->with('mj-column')
                        ->with('mj-text', 'Welcome to Zahper')
                            ->align('center');

        // 2 buttons with links.
        $body->with('mj-section')
                ->backgroundColor('#FFFFFF')
                    ->with('mj-column')
                        ->with('mj-button', 'Go to your Web App')
                            /*
                             * This is how you should use dynamic values
                             * so they are not cached. You compute them in
                             * the blade view and not in the method.
                             *
                             * This will not cache:
                             * ->href("{{ url('/') }}")
                             *
                             * This will cache:
                             * ->href(url('/'))
                             */
                            ->href("{{ url('/') }}")
                            ->target('_blank')
                            ->backgroundColor('#2C5281')
                            ->paddingTop('20px')
                            ->parent()
                        ->parent()
                    ->with('mj-column')
                        ->with('mj-button', 'Go to Zahper Github')
                            ->href('https://github.com/brunocfalcao/zahper')
                            ->target('_blank')
                            ->backgroundColor('#29AA66')
                            ->paddingTop('20px');

        // Baseline text.
        $body->with('mj-section')
                ->backgroundColor('#FFFFFF')
                ->paddingTop('20px')
                ->paddingBottom('20px')
                ->backgroundColor('#FFFFFF')
                    ->with('mj-column')
                        ->with('mj-text', 'This is a zahper mailable example<br/> <strong>Now go and build your amazing newsletter using Zahper!')
                            ->align('center')
                            ->fontSize('12px')
                            ->color('#A0AEC0');

        $body->with('mj-section')
                ->with('mj-column')
                    ->backgroundColor('#ED8936')
                        ->with('mj-text', "<a class='text-link' href='https://twitter.com/brunocfalcao'>Made by @brunocfalcao</a>&nbsp;&nbsp;&nbsp;<a class='text-link' href='https://www.github.com/brunocfalcao/zahper'>Zahper on Github</a>&nbsp;&nbsp;&nbsp;<a class='text-link' href='{{ zhp_url_unsubscribe(\$zhp_uuid) }}'>Unsubscribe</a>&nbsp;&nbsp;&nbsp;<a class='text-link' href='{{ zhp_url_view_in_browser(\$zhp_uuid) }}'>View in Browser</a>")
                            ->align('center')
                            ->paddingTop('5px')
                            ->paddingBottom('5px')
                            ->fontSize('12px')
                            ->color('#FFFFFF');

        // Footer spacer.
        $body->with('mj-section')
                ->with('mj-column')
                    ->with('mj-spacer')
                        ->height('50px');

        return $mjml;
    }

    /**
     * Build the message.
     *
     * @return void
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
