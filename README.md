
[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/support-ukraine.svg?t=1" />](https://supportukrainenow.org)

# An expressive fluent API wrapper around Recombee's SDK to use within Laravel applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jbaron-mx/laravel-recombee.svg?style=flat-square)](https://packagist.org/packages/jbaron-mx/laravel-recombee)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/jbaron-mx/laravel-recombee/run-tests?label=tests)](https://github.com/jbaron-mx/laravel-recombee/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/jbaron-mx/laravel-recombee/Check%20&%20fix%20styling?label=code%20style)](https://github.com/jbaron-mx/laravel-recombee/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jbaron-mx/laravel-recombee.svg?style=flat-square)](https://packagist.org/packages/jbaron-mx/laravel-recombee)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-recombee.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-recombee)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require jbaron-mx/laravel-recombee
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-recombee-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-recombee-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-recombee-views"
```

## Usage

```php
$recombee = new Baron\Recombee();
echo $recombee->echoPhrase('Hello, Baron!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jesus Baron](https://github.com/jbaron-mx)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
