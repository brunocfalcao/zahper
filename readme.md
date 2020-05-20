<p align="center"><img src="https://assets.waygou.com/zahper-github-header.jpg" width="150"></p>

<p align="center">
<a href="https://packagist.org/packages/brunocfalcao/zahper"><img src="https://poser.pugx.org/brunocfalcao/zahper/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/brunocfalcao/zahper"><img src="https://poser.pugx.org/brunocfalcao/zahper/license.svg" alt="License"></a>
</p>

## About Zahper

Flame is a Feature Development-driven framework that will improve the way you structure and
develop your Laravel application features.

This free package will allow you to:
* Create your features organized in a standard code-convention way, each of them inside a directory.
* Create and re-use "intelligent" widgets, called Twinkles, that will make you improve your layout code structure.
* Render Panels and Twinkles automatically given the route action that it's being called at a request.
* Be able to execute Twinkle controller actions prior to its rendering on the screen.
* Structure your application as feature modules, having a much better code readability, structure and reusability!

## Why Flame

I've built Flame because I was starting to have medium size web apps (like [Laraning](https://www.laraning.com) or [Laraflash](https://www.laraflash.com)) with a lot of Blade views, Blade Components, etc.
It was starting to be difficult to organize my features in a way that I could load data inside those views given for the respective controller action that I was running at a certain moment.

> A thought came to me: "What if I have a way to know automatically what actions am I running and then automatically load my graphical
layout accordingly to that action, reusing the layout and not just create more and more views?"

That's where Flame started. Flame will automate this behaviour for you. Let's see how.

## Installation

You can install this package via composer using this command:

```bash
composer require brunocfalcao/zahper
```

###### The package will automatically register itself (using [auto-discover](https://laravel-news.com/package-auto-discovery)).

Next step is to publish the flame.php configuration file into your config folder.

```bash
php artisan vendor:publish --tag=flame-configuration
```

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
