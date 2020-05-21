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

Next step is to publish the zahper.php configuration file into your config folder.

```bash
php artisan vendor:publish --tag=zahper-config
```

Final step is to install your mjml.io api keys in your .ENV configuration.

```bash
ZAHPER_API_URL=https://api.mjml.io/v1/render
ZAHPER_API_APPLICATION_ID=<your application id>
ZAHPER_API_SECRET_KEY=<your secret key>
```
##### :point_right: You need to register for the Api keys for your [MJML api application here](https://mjml.io/api/).

## No time to wait?

After having your api keys in your .ENV file, just do this for a quick email demo:

Run the following artisan command:
```bash
php artisan zahper:mailable DemoEmail --demo
```

Navigate in your local laravel app to the url /zahper/demo. [Et voilá](https://www.deepl.com/translator#fr/en/et%20voil%C3%A1!%7CThere%20you%20go.)!



All done! :smile:

## How it works

> The flame.php configuration file already have an entry to put all your features in the App\Flame\Features namespace.

Create a new feature using the following command:

```bash
php artisan make:feature
```

Select the "flame" namespace group, then create a "Manage Cars" feature, and the action "index".
At the end, the route example that the command give you will be:

```bash
Route::get('manage-cars', '\App\Flame\Features\ManageCars\Controllers\ManageCarsController@index')
     ->name('manage-cars.index');
```

##### :point_right: Copy+Paste this route example to your web.php file (or other route file you're using with web middleware).

##### :floppy_disk: A new folder "ManagesCars" is created inside your "app\Flame\Features" folder.

#### Feature "Manage Cars" file structure

```bash
  + ManageCars
    + Controllers
      > ManageCarsController.php
      > WelcomeController.php
    + Panels
      > index.blade.php
    + Twinkles
      > welcome.blade.php
```

Let's now see what was scaffolded on each of those files. The magic starts :heart: !

##### Controllers/ManageCarsController.php

```php
class ManageCarsController extends Controller
{
    public function index()
    {
        return flame();
    }
```

 :tada: This is where you mapped your route file You just need to return the flame() helper so Flame will load your respective
Panel and Twinkles for the "index" action. Meaning, if your Twinkles have the "index" action defined, they will run prior
to the Panel content rendering.

> In case you don't have a Panel with the same name, then it will fall back to default.blade.php. If you have a Panel with this name, it will be loaded for all of your actions that don't have a specific Panel action. Double sweet!

##### Panels/welcome.blade.php

```blade
@twinkle('welcome')
```

The Twinkle works like an "intelligent widget". It will render content defined in your Twinkes/ folder, given the argument passed.
In this case, the Twinkle will load the "welcome.blade.php".

BUT! More magic happens :heart: ...

Before rendering the Twinkle, it will try to find its own respective controller (studly case) name. In our case we do have it
in the Controllers/WelcomeController.php, so let's check it:

##### Controllers/WelcomeController.php

```php
class WelcomeController extends Controller
{
    public function index()
    {
        return ['text' => 'Hi there! This is a Twinkle!'];
    }
```

Since there is the same action defined for the current route action running, it will use reflection to run the method and
pass the data as an array. So you can then use it inside your Twinkle as a [Blade variable](https://laravel.com/docs/5.7/blade#displaying-data).
Meaning on this case, it will run the "index" method and return the data to the Welcome Twinkle.

> The Twinkle methods also work with implicit binding. Meaning if you define your arguments from the route parameters they will be
dynamically injected into your method arguments!

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

## Getting started

Flame creates a demo route on your /flame url. You can try it and should see:
<p align="center"><img src="https://flame.brunofalcao.me/assets/github/preview.jpg" width="400"></p>

This means that you have can see the Demo feature located in the Brunocfalcao\Flame\Features\Demo namespace.

## Creating your first Feature

Simple as this. Just write the following command:

```bash
php artisan make:feature
```

## Contributing

At the moment you don't need to contribute since Flame is still in development.

## License

Waygou Flame is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
