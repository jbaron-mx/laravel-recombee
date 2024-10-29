![](https://banners.beyondco.de/Laravel%20Recombee.png?theme=light&packageManager=composer+require&packageName=jbaron-mx%2Flaravel-recombee&pattern=architect&style=style_1&description=Seamless+integration+of+AI-powered+recommendations&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

<p align="center">
<a href="https://packagist.org/packages/jbaron-mx/laravel-recombee"><img src="https://img.shields.io/packagist/v/jbaron-mx/laravel-recombee.svg?style=flat-square" alt="Latest Stable Version"></a>
<a href="https://github.com/jbaron-mx/laravel-recombee/actions/workflows/run-tests.yml?query=branch%3Amain"><img src="https://img.shields.io/github/actions/workflow/status/jbaron-mx/laravel-recombee/run-tests.yml?label=tests&branch=main" alt="GitHub Tests Action Status"></a>
<a href="https://github.com/jbaron-mx/laravel-recombee/actions/workflows/php-cs-fixer.yml?query=branch%3Amain"><img src="https://img.shields.io/github/actions/workflow/status/jbaron-mx/laravel-recombee/php-cs-fixer.yml?label=code%20style&branch=main" alt="GitHub Code Style Action Status"></a>
<a href="https://packagist.org/packages/jbaron-mx/laravel-recombee"><img src="https://img.shields.io/packagist/dt/jbaron-mx/laravel-recombee.svg?style=flat-square" alt="Total Downloads"></a>
</p>

------

[Recombee](https://www.recombee.com/) is an **AI-powered recommendation engine** that delivers amazing user experiences with recommendations based on users' behavior and interests.

This package is a [Recombee PHP SDK](https://github.com/Recombee/php-api-client) wrapper for Laravel. It provides an **expressive fluent API** to seamlessly integrate **personalized recommendations** into your application in the *Laravel way*. Heavily inspired in [Laravel Scout](https://github.com/laravel/scout/).

---

## Supports

* **PHP:** 8.0, 8.1, 8.2
* **Laravel:** 8, 9, 10, 11

## Prerequisites

1. Create an account in [Recombee](https://www.recombee.com/).
2. Create a database within your account.

## Installation & Setup

Install with Composer:
```sh
composer require jbaron-mx/laravel-recombee
```

Publish config file:
```sh
php artisan vendor:publish --tag="recombee-config"
```

Add to your `.env` file:
> Replace the values with your database details from Recombee.
```env
RECOMBEE_DATABASE="my-store"
RECOMBEE_TOKEN="token"
RECOMBEE_REGION="us-west"
```

Add your corresponding models to your `config/recombee.php`:
```php
'user' => App\Models\User::class,
'item' => App\Models\Product::class,
```

Add `Recommendable` trait to your corresponding models:
```php
use Baron\Recombee\Recommendable;

class User extends Authenticatable
{
    use Recommendable;
    ...
```
```php
use Baron\Recombee\Recommendable;

class Product extends Model
{
    use Recommendable;
    ...
```

## Quick Usage

> For full documentation please visit the [wiki](https://github.com/jbaron-mx/laravel-recombee/wiki).

Create properties in your Recombee database:
```php
use Baron\Recombee\Facades\Recombee;

// Create a user property
Recombee::user()
    ->property('active', 'boolean')    // 2nd argument is optional, string by default.
    ->save();

// Create multiple user properties
Recombee::user()->properties([
    'name' => 'string',
    'age' => 'int',
    'active' => 'boolean',
])->save();

// Create an item property
Recombee::item()
    ->property('available', 'boolean')    // 2nd argument is optional, string by default.
    ->save();

// Create multiple item properties
Recombee::item()->properties([
    'description' => 'string',
    'price' => 'double',
    'available' => 'boolean',
])->save();
```

Import users and items:
> For batch import, please visit the [Batch Import](https://github.com/jbaron-mx/laravel-recombee/wiki/3.-Batch-Import) section in the wiki.
```php
use Baron\Recombee\Facades\Recombee;

// Import a user
Recombee::user($userId, [
    'name' => 'John Doe',
    'age' => 29,
    'active' => true,
])->save();

// Import a user via model
User::first()->recommendable();

// Import an item
Recombee::item($itemId, [
    'description' => 'Magic Keyboard 3',
    'price' => 59.99,
    'available' => true,
])->save();

// Import an item via model
Product::first()->recommendable();
```

Retrieve users and items:
> get() returns an instance of `Collection` for which all its convenient methods are available, refer to [Laravel Docs for all available methods](https://laravel.com/docs/master/collections#available-methods).
```php
use Baron\Recombee\Facades\Recombee;

// Basic get limited to 25 results by default
Recombee::user()->get(); 
Recombee::item()->get(); 

// Same methods are available for users and items
Recombee::item()
    ->select('description', 'price', 'available')   // Select these properties only
    ->take(50)                                      // Limited to 50 results
    ->option('filter', "'price' > 25")              // Filtered by price
    ->get()
```

Create interactions:
```php
use Baron\Recombee\Facades\Recombee;

// User has viewed this item
Recombee::user($userId)->viewed($itemId)->save();

// User has purchased this item
Recombee::user($userId)->purchased($itemId)->save();

// User has rated this item (Scale from -1.0 to 1.0, see docs)
Recombee::user($userId)->rated($itemId, 0.5)->save();

// User has added this item to his cart
Recombee::user($userId)->carted($itemId)->save();

// User has bookmarked this item
Recombee::user($userId)->bookmarked($itemId)->save();

// User has partially viewed this item (Scale from 0 to 1, see docs)
Recombee::user($userId)->viewedPortion($itemId, 0.5)->save();
```

Get personalized recomendations:
```php
use Baron\Recombee\Facades\Recombee;

// Recommended items for a given user, typically used in a "Picked just for you" section.
Recombee::user($userId)->recommendItems()->take(50)->get();

// Recommended users for another given user, based on the user's past interactions and values of properties.
Recombee::user($userId)->recommendUsers()->get();

// Recommended items that are related to a given item, typically used in a "Similar Products" section.
Recombee::item($itemId)->recommendItems()->get();

// Recommended users that are likely to be interested in a given item.
Recombee::item($itemId)->recommendUsers()->get();
```

## Documentation

Please visit the [wiki](https://github.com/jbaron-mx/laravel-recombee/wiki) for full documentation.

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

- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
