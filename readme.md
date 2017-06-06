# Laravel Maki 🍣

Create a CMS-like system with Laravel Maki, by using re-usable sections to
display your content.

## Requirements

- PHP >= 7.0
- Laravel 5.4
- [TwigBridge](https://github.com/rcrowe/TwigBridge/)

## Installation

- Installation must be done through [Composer](https://getcomposer.org/):
`composer require startup-palace/laravel-maki`
- Add the service provider in your `app/config.php`:

	```php
	'providers' => [
		...
		\StartupPalace\Maki\Providers\ServiceProvider::class,
	],
	```

- Publish the config: `php artisan vendor:publish --provider="StartupPalace\Maki\Providers\ServiceProvider" --tag="config"`
- In your `App\Providers\AppServiceProvider::boot()` method, add the container bindings:

	```php
	public function boot()
    {
       	\StartupPalace\Maki\Maki::containerBindings();
    }
    ```

- At the end of your `App\Providers\RouteServiceProvider::map()`, add the "catch-all" route:

	```php
	public function map()
    {
        ...
        Maki::routes();
    }
	```
