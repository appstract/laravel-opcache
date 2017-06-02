# Laravel OPcache

[![Latest Version on Packagist](https://img.shields.io/packagist/v/appstract/laravel-opcache.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-opcache)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/appstract/laravel-opcache.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-opcache)

[<img src="header.png?raw=true">](https://medium.com/appstract/make-your-laravel-app-fly-with-php-opcache-9948db2a5f93)

This package contains some useful Artisan commands to work with PHP OPcache.

#### If you want to learn more about OPcache and what it can do for your Laravel app, you can [read the article on Medium](https://medium.com/appstract/make-your-laravel-app-fly-with-php-opcache-9948db2a5f93#.bjrpj4h1c).

## Installation

You can install the package via Composer:

``` bash
composer require appstract/laravel-opcache
```

Then register the service provider to your `config/app.php` file:

```php
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
'url' => env('APP_URL'),
```
Make sure your APP_URL is set correctly in .env.
If you want to set a different url to call the OPcache routes (for use with a load balancer for example),
you can set OPCACHE_URL.

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

Appstract is a small team from The Netherlands. We create (open source) tools for webdevelopment and write about related subjects on [Medium](https://medium.com/appstract). You can [follow us on Twitter](https://twitter.com/teamappstract), [buy us a beer](https://www.paypal.me/teamappstract/10) or [support us on Patreon](https://www.patreon.com/appstract).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
