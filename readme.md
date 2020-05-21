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
The $cache static attribute will allow you to cache your MJML compiled view, so in case you have 500 emails to be sent, you don't call the MJML api 500 times. You should make it false until you tested your newsletter and finally turn it true when you decide to use it in your website.

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
