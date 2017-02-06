# Laravel OPcache package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/appstract/laravel-opcache.svg?style=flat-square)](https://packagist.org/packages/appstract/:package_name)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/appstract/laravel-opcache/master.svg?style=flat-square)](https://travis-ci.org/appstract/:package_name)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/xxxxxxxxx.svg?style=flat-square)](https://insight.sensiolabs.com/projects/xxxxxxxxx)
[![Quality Score](https://img.shields.io/scrutinizer/g/appstract/laravel-opcache.svg?style=flat-square)](https://scrutinizer-ci.com/g/appstract/:package_name)
[![Total Downloads](https://img.shields.io/packagist/dt/appstract/laravel-opcache.svg?style=flat-square)](https://packagist.org/packages/appstract/:package_name)

This package contains some useful Artisan commands to work with PHP OPcache.

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

Make sure your APP_URL is set correctly.
## Usage

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
Programmatic usage:

```php
// use Appstract\Opcache\OpcacheFacade as OPcache;

OPcache::clear()
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email hello@appstract.team instead of using the issue tracker.

## Credits

- [Olav van Schie](https://github.com/ovanschie)
- [All Contributors](../../contributors)

## About Appstract

Appstract is a small team from The Netherlands. <3 Laravel, Vue and other awesome tools.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
