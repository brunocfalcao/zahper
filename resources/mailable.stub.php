<?php

namespace App\Mail;

use Brunocfalcao\Zahper\ZahperComponent;
use Brunocfalcao\Zahper\ZahperMailable;
use Brunocfalcao\Zahper\ZahperTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class MyMailable extends ZahperMailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //If you don't want to use cache, uncomment. PLEASE ready below
        //the consequences of not using cache!
        //ZahperTemplate::dontCache();
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
     * Don't worry about template caching. It's done automatically by zahper
     * so in case this template was already rendered, it will not be
     * rendered again (sweet!).
     *
     * REMARKS:
     * 1. The output is your view rendered. Meaning you can use things like:
     * $with('mj-text', "{{ \$variable }}").
     *
     * 2. This view is, by default, cached. In case you don't want to cache
     * it you need to use uncomment the line in the constructor method.
     *
     * 3. If you don't cache, you are hitting the MJML API each time you
     * render the mailable! So, if you are sending 500 newsletters you will
     * use the API 500 times! Make sure don't get your API blocked due to this
     * mistake.
     *
     * 3. The cache content is static, but the view rendering is not.
     * As examples:
     * ->with('mj-text', 'Hi there ' . Str::random(10));
     * will be cached with the same random number.
     *
     * ->with('mj-text', 'Hi there {{ str_random(10) }}');
     * will NOT be cached since it is calculated directly in the view.
     *
     * 3. If you are using components with "src" attribute, it will be
     * parsed to CID in case you have defined that in your config file.
     * Still, you always pass your path. The conversion to CID and rendered as
     * $message->embed([...]) is automatically done by zahper (sweet again!).
     *
     * @return ZahperComponent
     */
    protected function template()
    {
        $mjml = ZahperComponent::make();

        $head = $mjml->with('mj-head');

        $head->with('mj-preview', 'Monthly News #1');
        $head->with('mj-style', '.text-link { color: #D3751A } .text-link-inverse { color: #FFFFFF }', ['inline' => 'inline']);
        $head->with('mj-font', ['name' => "Nunito", 'href' => 'https://fonts.googleapis.com/css?family=Nunito']);
        $head->with('mj-attributes')
                ->with('mj-all', ['font-family' => "Nunito, system-ui, -apple-system, BlinkMacSystemFont", 'font-size' => '0.90rem', 'letter-spacing' => '0.04rem', 'line-height' => '1.5rem', 'padding' => '0px']);

        $body = $mjml->with('mj-body')
                     ->backgroundColor('#2D3748')
                     ->width('600px');

        $body->with('mj-section')
                ->with('mj-column')
                    ->with('mj-spacer')
                    ->height('50px');

        $body->with('mj-section')
             ->backgroundColor('#F7FAFC')
                ->with('mj-column')
                    ->with('mj-image')
                    ->src('https://masteringnova.com/images/email-header.jpg');

        $body->with('mj-section')
             ->backgroundColor('#E2E8F0')
             ->paddingTop('20px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
             ->paddingBottom('20px')
                ->with('mj-column')
                ->width('100%')
                    ->with('mj-text', 'Monthly News #1')
                    ->fontSize('18px')
                    ->align('center');

        $body->with('mj-section')
             ->backgroundColor('#D3751A')
             ->paddingTop('15px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
             ->paddingBottom('15px')
                ->with('mj-column')
                ->width('100%')
                    ->with('mj-text', 'FREE Tutorial Video link below')
                    ->align('center')
                    ->color('#FFFFFF');

        $body->with('mj-section')
             ->backgroundColor('#E2E8F0')
             ->paddingTop('30px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
                ->with('mj-column')
                ->width('100%')
                    ->with('mj-text', "Hi !");

        $body->with('mj-section')
             ->backgroundColor('#E2E8F0')
             ->paddingTop('30px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
                ->with('mj-column')
                ->width('100%')
                    ->with('mj-text', "These first weeks I was recording like crazy!");

        $body->with('mj-section')
             ->backgroundColor('#E2E8F0')
             ->paddingTop('30px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
                ->with('mj-column')
                ->width('100%')
                    ->with('mj-text', "Already recorded 11 tutorials, and I am very close to finish the first chapter, Fundamentals of Laravel Nova.");

        $body->with('mj-section')
             ->backgroundColor('#E2E8F0')
             ->paddingTop('30px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
                ->with('mj-column')
                ->width('100%')
                    ->with('mj-text', "On each of those videos, I always try to show you a small \"gem\" from my experience working with Nova, even if you already know Nova I invite you to see those videos since I normally bring something different at the end of each :)");

        $body->with('mj-section')
             ->backgroundColor('#E2E8F0')
             ->paddingTop('30px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
             ->paddingBottom('20px')
                ->with('mj-column')
                ->width('100%')
                    ->with('mj-text', "I am also working in the new <a href=\"https://www.laraning.com\" class=\"text-link\">Laraning</a> website, since all the course videos will be posted there. Will send you some screenshots in my next newsletter!");

        $body->with('mj-section')
             ->backgroundColor('#E2E8F0')
             ->paddingTop('10px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
             ->paddingBottom('15px')
                ->with('mj-column')
                ->width('100%')
                    ->with('mj-text', "Best,<br/> Bruno");

        $body->with('mj-section')
             ->backgroundColor('#D3751A')
             ->paddingTop('15px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
             ->paddingBottom('15px')
                ->with('mj-column')
                ->width('100%')
                    ->with('mj-text', "As I announced on Twitter, here is my first <a href=\"https://vimeo.com/417004687/8e501c0091\" class=\"text-link-inverse\">FREE video for you</a> about how to customize your Laravel Nova global search results. Enjoy!")
                    ->color('#FFFFFF')
                    ->align('center');

        $body->with('mj-section')
             ->backgroundColor('#CFCFCF')
             ->paddingTop('10px')
             ->paddingLeft('20px')
             ->paddingRight('20px')
             ->paddingBottom('10px')
                ->with('mj-column')
                ->width('50%')
                    ->with('mj-text', "<a class='text-link' href='https://masteringnova.com'>Mastering Nova</a>")
                    ->align('center')
                    ->fontSize('12px')
                ->parent()
            ->parent()
                ->with('mj-column')
                ->width('50%')
                    ->with('mj-text', "<a class='text-link' href='https://twitter.com/brunocfalcao'>Follow me on Twitter</a>")
                    ->align('center')
                    ->fontSize('12px');

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
                'bruno@masteringnova.com',
                'Bruno Falcao from Mastering Nova'
            )
            ->subject('During May - Lots of progress!');

        parent::build();
    }
}
