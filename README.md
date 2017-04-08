# Laravel OPcache

[![Latest Version on Packagist](https://img.shields.io/packagist/v/appstract/laravel-opcache.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-opcache)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/appstract/laravel-opcache.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-opcache)

![Opcache](header.png?raw=true)

This package contains some useful Artisan commands to work with PHP OPcache.

#### If you want to learn more about OPcache and what it can do for your Laravel app, you can read [the article](https://medium.com/appstract/make-your-laravel-app-fly-with-php-opcache-9948db2a5f93#.bjrpj4h1c) on Medium.

## Installation

You can install the package via composer:

``` bash
composer require appstract/laravel-opcache
```

Then register the service provider:

```php
// config/app.php
'providers' => [
    ...
    Appstract\Opcache\OpcacheServiceProvider::class,
];
```

For Lumen:
```php
// bootstrap/app.php
$app->register(Appstract\Opcache\OpcacheServiceProvider::class);

// config/app.php
'app.url' => env('APP_URL'),
```
##### Make sure your APP_URL is set correctly in .env.

## Usage
Login to your server/vm and run one of the commands.
##### Requests are only excepted from the same IP as the server IP.

Clear OPcache:
``` bash
php artisan opcache:clear
```

Show OPcache config:
``` bash
php artisan opcache:config
```

Show OPcache status:
``` bash
php artisan opcache:status
```

Pre-compile your application code (experimental):
``` bash
php artisan opcache:optimize
```

Programmatic usage:

```php
use Appstract\Opcache\OpcacheFacade as OPcache;

...

OPcache::clear();
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/appstract/laravel-opcache/graphs/contributors) :)

## About Appstract

Appstract is a small team from The Netherlands. <3 Laravel, Vue and other awesome tools.

## Buy Us A Beer

Would be awesome if you would [buy us a beer](https://www.paypal.me/teamappstract/10)! Or [a lot of beer](https://www.patreon.com/appstract) :)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
