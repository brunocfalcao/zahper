<p align="center"><img src="https://assets.waygou.com/zahper-github-header_v2.jpg" width="130"></p>

<p align="center">
<a href="https://packagist.org/packages/brunocfalcao/zahper"><img src="https://poser.pugx.org/brunocfalcao/zahper/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/brunocfalcao/zahper"><img src="https://poser.pugx.org/brunocfalcao/zahper/license.svg" alt="License"></a>
</p>

## About Zahper

Zahper is a [Laravel](https://www.laravel.com) *on-steroids* Mailable that lets you create beautiful cross-browser email newsletters using [MJML](https://mjml.io).

## Why Zahper

Zahper will solve you these problems:
* Frustration of creating email templates, and at the end verifying they are not browser-compatible.
* Annoyance of having to recreate email templates without a common base template structure to kick off.
* Complexity of creating "view in browser" links, like having to create a db/file model for storage.
* Rebuilding a Laravel package to send emails.

## Zahper Features

You get all of this out-of-the-box:
* Build your MJML template in an eloquent way, directly on your Mailable class, using all the MJML features and components.
* Automated MJML to Blade view compilation via the [MJML Api](https://mjml.io/api).
* Caching mechanism, so you don't make 500 Api calls, when you send 500 emails.
* Automatic "view in browser" link generation, in case you want to redirect your users to view the email in the browser.
* High customizable (storage and views cache, image rendering types, etc) via a config file.
* Automatic image [CID / URL](https://laravel.com/docs/7.x/mail#inline-attachments) rendering.
* Already being used in [masteringnova.com](https://www.masteringnova.com), [Laraning](https://www.laraning.com) and [Laraflash](https://www.laraflash.com).
* You can also use the full original Mailable class capabilites since Zahper inherits from the Laravel [Mailable](https://laravel.com/docs/7.x/mail) class.

## Installation

You can install Zahper via composer using this command:

```bash
composer require brunocfalcao/zahper
```

###### The package will automatically register the service provider (using [auto-discover](https://laravel-news.com/package-auto-discovery)).

Next step is to publish your zahper.php configuration.

```bash
php artisan vendor:publish --tag=zahper-config
```

Final step is to install your mjml.io api keys in your .ENV configuration.

```bash
ZAHPER_API_URL=https://api.mjml.io/v1/render
ZAHPER_API_APPLICATION_ID=<your application id>
ZAHPER_API_SECRET_KEY=<your secret key>
```
##### :point_right: You need to register for the Api keys for your [MJML api application here](https://mjml.io/api/). It's free.

## No time to wait?

After having your api keys in your .ENV file, just do this for a quick email demo:

Run the following artisan command:
```bash
php artisan zahper:demo
```

Navigate in your local laravel app to the url /zahper/demo. [Et voilá](https://www.deepl.com/translator#fr/en/et%20voil%C3%A1!%7CThere%20you%20go.), you should see a mailable demo.

<p align="center"><img src="https://assets.waygou.com/zahper-demo.jpg" width="500px"></p>

## How it works

Zahper uses the power of MJML syntax to render an HTML email that will be cross-browser compatible. To do this, you first need to learn MJML, and believe me it's pretty straight forward. You can check the [documentation here](https://mjml.io/documentation/).

Additionally it leverages the full features of the Laravel Mailable that you can use. So, it's 100% compatible with any Mailable-based codebase you did.

## How to use Zahper

  
1. Start by creating your zahper mailable using the following example:
```bash
php artisan zahper:mailable WelcomeMailable
```

> This command will create your new mailable in the app\Mail folder.

2. Inside your zahper mailable, you have the following methods:

```php
    public function __construct()
    {
        // --- Zahper code ---
        ZahperTemplate::$cache = false;
        // [...]
        // --- /Zahper code ---
    }
```
The $cache static attribute will allow you to cache your MJML compiled view, so in case you have 500 emails to be sent, you don't call the MJML api 500 times. You should make it false until you tested your newsletter and finally turn it true when you decide to use it in your website. More about the cache later in this readme.

```php
    protected function template()
    {
        $mjml = ZahperComponent::make();

        $head = $mjml->with('mj-head');
        // $head->with(...)

        $body = $mjml->with('mj-body');
        // $body->with(...)

        return $mjml;
    }
```
This is where the magic happens. You will write your MJML and Zahper will call the MJML api to compile it to a view.
As a quick example (more examples later in this readme) the following MJML:

```mjml
    <mj-section>
        <mj-column>
            <mj-text>Hi there!</mj-text>
        </mj-column>
    </mj-section>
```

is written in Zahper like this:

```php
    $section = ZahperComponent::make('mj-section')
               ->with('mj-column')
                   ->with('mj-text', 'Hi there!');

```

and the final method:

```php
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
```

Is used to configure your Mailable "from" recipient and the subject.

:point_up: All the Laravel Mailable features are available for you, except the "build" method. As example, you can pass public attributes, and they will also be available in the MJML rendered view!

## How do you code the MJML

Coding your MJML is made in a very natural way.

1. You create the component:

```php
    $body = ZahperComponent::make('mj-section');
```

2. You then add all your attributes in 2 ways, as example:

```php
    $body->align('center')
    
    or 
    
    $body = ZahperComponent::make('mj-section', ['align' => 'center');
```

Let's see another examples, so you can learn it better:

```mjml
    <mj-section padding="40px" background-color="#FFFFFF">
        <mj-column>
            <mj-text align="center" color="#1a202c" font-size="20px">Hey there!</mj-text>
        </mj-column>
    </mj-section>
```

is written like:

```php
    $section = ZahperComponent::make('mj-section')
               ->padding('40px')
               ->backgroundColor('#FFFFFF')
                   ->with('mj-column')
                       ->with('mj-text', 'Hey there!')
                           ->align('center')
                           ->color('#1A202C')
                           ->fontSize('20px')
```

The coding way is "natural". Meaning you create your component, then if you want to add a child component you use the ->with(), and if you want to pass properties, you just keep adding them as methods. You just need to respect that attribute name convention, like "background-color" should be ->backgroundColor(). And that's it ! Zahper then converts it to a pure MJML, calls the MJML Api to convert it to a blade view, and calls the ->build() Mailable method!

:question: What happens if you want to code 2 columns?

Simple. You have a ->parent() method that goes 1 level in the MJML hierarchy :blush:

```mjml
    <mj-section padding="40px" background-color="#FFFFFF">
        <mj-column>
            <mj-text>First Column</mj-text>
        </mj-column>
        <mj-column>
            <mj-text>Second Column</mj-text>
        </mj-column>
    </mj-section>
```

is written like:

```php
    $section = ZahperComponent::make('mj-section')
                   ->with('mj-column')
                       ->with('mj-text', 'First Column')
                           ->parent()
                       ->parent()
                   ->with('mj-column')
                       ->with('mj-text', 'Second Column');
```

## Caching strategy

Zahper needs to have a caching strategy since when you are sending a high volume of emails we cannot just call the MJML Api to convert the same MJML over and over. You can suddenly see your MJML Api account blocked in case spikes occur. So, Zahper allows you to cache your blade view so the next time the same Mailable class is called it doesn't recompile the mjml, but just uses the cached view content.

### Things you need to pay attention

#### Activating the Zahper Mailable cache

The way you turn on, or off the Mailable cache is in your generated Zahper Mailable, in the construct() method:

```php
    public function __construct()
    {
        // --- Zahper code ---
        ZahperTemplate::$cache = false;
        // [...]
        // --- /Zahper code ---
    }
```

:exclamation: Keep it off until you have your newsletter structure all fine tuned. Then you turn it on and the MJML Api, for this Mailable, will not be called again until you turn it on again.

#### Using dynamic values on your Zahper Mailable

Let's say you want to have, for instance, a dynamic URL in a Button href attribute with a distinct user id per email.

```mjml
    <mj-button href="{{ route('welcome', ['user_id' => $id]) }}">Click here to Browse</mj-button>
```

You then should write it this way:

```php
    $button = ZahperComponent::make('mj-button')
                ->href("{{ route('welcome', ['user_id' => \$id]) }}")
```

:exclamation: If you write it this way below, the user id will get cached. So you will send 500 emails, to 500 recipients, all of them with the same user id!

```php
    $button = ZahperComponent::make('mj-button')
                ->href(route('welcome', ['user_id' => \$id]))
```

## View in Browser

For each sent email, Zahper stores a copy in your storage folder with a distinct UUID.
You can access this UUID only during the lifecycle of the Mailable. After that it's discarded and re-generated again.

The UUID is accessed in your mailable via:

```php
    [...]
    $uuid = $this->zhp_uuid;
    [...]
```

You can also configure the route and action called directly in the zahper configuration file.

Also, you have a helper that will generate the full url for you, so you can use it on your MJML code:
```php
    [...]
        ->with('mj-button', 'View in Browser')
            ->href("{{ zhp_url_view_in_browser(\$zhp_uuid) }}")
            ->target('_blank');
    [...]
```

## Unsubscribe

Like the View in Browser, the UUID is also used for the unsubscribe. Zahper will have a default route that you can use, but the action doesn't do more than calling an event. So it's up to you to inject a listener.

ZahpController@unsubscribe action:

```php
    public function unsubscribe(string $uuid)
    {
        event(new ZahperUnsubscribeEvent($uuid));

        return response('Thank you, you have been unsubscribed!', 200);
    }
```



## Current development status
- [x] Finish core development.
- [ ] Finish identified issues/improvements for Alpha release 0.1.x.
- [ ] Close Alpha (0.1.x) release.
- [ ] Finish identified issues/improvements for Beta release 0.2.x.
- [ ] Close Beta (0.2.x) release.
- [ ] Test coverage > 90%.
- [ ] Finalize documentation.
- [ ] Finalize video tutorials.
- [ ] Release for General Public use.

## Contributing

At the moment you don't need to contribute since Zahper is still in early-production release. You can already use it in your production website but still pay attention to my repository for issues that might impact you.

## License

Waygou Flame is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
