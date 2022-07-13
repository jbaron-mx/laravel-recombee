![](https://banners.beyondco.de/Laravel%20Recombee.png?theme=light&packageManager=composer+require&packageName=jbaron-mx%2Flaravel-recombee&pattern=architect&style=style_1&description=Seamless+integration+of+AI-powered+recommendations&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

<p align="center">
<a href="https://packagist.org/packages/jbaron-mx/laravel-recombee"><img src="https://img.shields.io/packagist/v/jbaron-mx/laravel-recombee.svg?style=flat-square" alt="Latest Stable Version"></a>
<a href="https://github.com/jbaron-mx/laravel-recombee/actions?query=workflow%3Arun-tests+branch%3Amain"><img src="https://img.shields.io/github/workflow/status/jbaron-mx/laravel-recombee/run-tests?label=tests" alt="GitHub Tests Action Status"></a>
<a href="https://github.com/jbaron-mx/laravel-recombee/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain"><img src="https://img.shields.io/github/workflow/status/jbaron-mx/laravel-recombee/Check%20&%20fix%20styling?label=code%20style" alt="GitHub Code Style Action Status"></a>
<a href="https://packagist.org/packages/jbaron-mx/laravel-recombee"><img src="https://img.shields.io/packagist/dt/jbaron-mx/laravel-recombee.svg?style=flat-square" alt="Total Downloads"></a>
</p>

------

[Recombee](https://www.recombee.com/) is an **AI-powered recommendation engine** that delivers amazing user experiences with **recommendations based on users' behavior and interests**.

This package is a [Recombee PHP SDK](https://github.com/Recombee/php-api-client) wrapper for Laravel. It provides an **expressive fluent API** to seamlessly integrate **personalized recommendations** into your application in the *Laravel way*. Heavily inspired in [Laravel Scout](https://github.com/laravel/scout/).

## Requirements

The first thing you need is your database at Recombee and the corresponding secret key. Create a free instant account at [recombee.com](https://www.recombee.com/), if you don’t have one yet.

> **This package requires:**
- **[PHP 8.0+](https://php.net/releases/)**
- **[Laravel 8.0+](https://github.com/laravel/laravel)**

## Installation

You can install the package via composer:

```bash
composer require jbaron-mx/laravel-recombee
```

After installing, you should publish the configuration file with:

```bash
php artisan vendor:publish --tag="laravel-recombee-config"
```

## Configuration

Set your Recombee `database`, `token`, and `region` settings within your application's `.env` file:

```bash
RECOMBEE_DATABASE="my-store"
RECOMBEE_TOKEN="token"
RECOMBEE_REGION="us-west"
```

Add your Eloquent models to `config/recombee.php`:
```php
'user' => App\Models\User::class,
'item' => App\Models\Item::class,
```

Finally, apply the `Baron\Recombee\Recommendable` trait to your `User` and `Item` models:

```php
use Baron\Recombee\Recommendable;

class User extends Authenticatable
{
	use Recommendable;
	...
```

```php
use Baron\Recombee\Recommendable;

class Item extends Model
{
	use Recommendable;
	...
```

### Configuring Recommendable Data

By default, the entire `toArray` form of a given model will be persisted to Recombee. If you would like to customize the data that is synchronized to the database, you may override the `toRecommendableArray` method on the model:

```php
class User extends Authenticatable
{
	use Recommendable;
	...

	public function toRecommendableArray()
	{
		return [
			'name' => $this->name,
			'age' => $this->age,
			'active' => $this->active,
		];
	}
```

Additionally, by default, all data properties will be persisted as string types to Recombee. If you would like to customize the types, you may override the `toRecommendableProperties` method on the model:

> Please visit [Recombee's API docs](https://docs.recombee.com/api.html#add-user-property) for all valid property types.

```php
class User extends Authenticatable
{
	use Recommendable;
	...

	public function toRecommendableProperties()
	{
		return [
			'name' => 'string',
			'age' => 'int'
			'active' => 'boolean',
		];
	}
```

### Modifying the Import Query

If you would like to modify the query that is used to retrieve all of your models for batch importing, you may define a `makeAllRecommendableUsing` method on your model. This is a great place to add any eager relationship loading that may be necessary before importing your models:

```php
use  Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
	use Recommendable;
	...
	
	protected function makeAllRecommendableUsing(Builder $query)
	{
		return $query->with('country');
	}
```

## Importing users/items

The most important thing for the recommender system to function properly is **data**, you may start by importing existing users and items to the Recombee's database.

### Batch Import via Artisan Command

This package provides a `recombee:import` Artisan command that you may use to import all of your existing records into your Recombee database.

```bash
# Import all users and items
php artisan recombee:import

# Import users only
php artisan recombee:import -u

# Import items only
php artisan recombee:import -i
```

### Batch Import via Programmatically

The static method `makeAllRecommendable` is available on your model to import all of your existing records. Functionally, it is identical to using the Artisan command from right above.

```php
User::makeAllRecommendable();
Item::makeAllRecommendable();
```

## Managing Properties

If you are not batch importing existing records from the start, then it is very important that you create all the user and item properties that will be used within your application, otherwise you might get errors when adding new records to Recombee.

### Get existing properties

```php
use  Baron\Recombee\Facades\Recombee;

// Get an existing property
Recombee::user()->property('name')->get();

// Get all existing properties
Recombee::item()->properties()->get();
```

### Creating properties

```php
use  Baron\Recombee\Facades\Recombee;

// Creating a single property at a time
Recombee::user()->property('name')->save(); # String type by default
Recombee::user()->property('active', 'boolean')->save();

// Creating multiple properties at once
Recombee::item()->properties([
	'description'			# String type by default
	'price' => 'double',
	'available' => 'boolean',
])->save();
```

### Deleting properties

```php
use  Baron\Recombee\Facades\Recombee;

// Deleting a single property
Recombee::user()->property('name')->delete();

// Deleting multiple properties at once
Recombee::item()
	->properties(['description', 'price', 'available'])
	->delete();
```

## Adding/Updating Records

### Adding via Eloquent Model

Once you have added the `Baron\Recombee\Recommendable` trait to a model, all you need to do is call the `recommendable` method on a model instance and it will automatically be added to your Recombee database.

> If a record already exists in Recombee, it will be updated with the new values given.

```php
// Adding a single model
User::first()->recommendable();

// Importing a collection of models
Item::where('active', true)->get()->recommendable();
```

### Adding via Facade

The `Recombee` facade provides a `user` and `item` methods that you can use to manually add a record into Recombee. You can either pass a model instance or an ID and its data (optionally):

```php
use  Baron\Recombee\Facades\Recombee;

// Passing model instance
$model = User::first();
Recombee::user($model)->save();

// Passing raw data
Recombee::item(1, [
	'description' => '4K Screen TV',
	'price' => 209.99
])->save();
```

In some cases, depending on your application, it could be valuable to also add guest users to your Recombee database, you can do this by passing a unique string as the user id, such as a session id:

```php
use  Baron\Recombee\Facades\Recombee;

Recombee::user('guest-user-session-id')->save();
```

## Removing Records

### Removing via Eloquent Model

To remove a record from Recombee you may simply call the `unrecommendable` method on the model instance.

```php
// Remove a single model
User::first()->unrecommendable();

// Remove a collection of models
Item::where('active', true)->get()->unrecommendable();
```

### Removing via Facade

The `Recombee` facade provides a `user` and `item` methods that you can use to manually remove a record from Recombee using the `delete` method. You can either pass a model instance or an ID:

```php
use  Baron\Recombee\Facades\Recombee;

// Passing model instance
$model = User::first();
Recombee::user($model)->delete();

// Passing raw ID
Recombee::item(1)->delete();
```

## Merging Users

This package provides a `mergeTo` method for merging the interactions of two different users under a single user ID, this is especially useful for online e-commerce applications working with guest users identified by unique tokens such as the session ID.

> Please visit [Recombee API docs](https://docs.recombee.com/api.html#merge-users) for more information on merging users.

```php
use  Baron\Recombee\Facades\Recombee;

$targetUser = User::first();
Recombee::user('guest-user-session-id')->mergeTo($targetUser)->save();
```

## List Users/Items

```php
use  Baron\Recombee\Facades\Recombee;

Recombee::user()->get();
Recombee::user()->paginate();

Recombee::item()->get();
Recombee::item()->paginate();
```

## Getting Recommendations

### Recommended Items
```php
use  Baron\Recombee\Facades\Recombee;

# Basic usage via facade
Recombee::user($userId)->recommendItems()->get();

# Basic usage via model
User::first()->recommendItems()->get();
```

### Recommended Users
```php
use  Baron\Recombee\Facades\Recombee;

// Basic usage via facade
Recombee::user($userId)->recommendUsers()->get();


// Basic usage via model
User::first()->recommendUsers()->get();
```

## Interactions

There are [multiple kinds](https://docs.recombee.com/api.html#user-item-interactions) of interactions supported by Recombee, you will find below a summary of the actions that can be called against a user or item either by using the facade or a model instance.

```php
Recombee::user($userId)->{interactionMethod}
User::first()->{interactionMethod}
```

> Note: Listing interactions can be called against a user or item, but saving or deleting an interaction can only be called against a user.

### Detail Views

 - Get: `views()->get()` *(Callable against a user or item)*
 - Create: `viewed($itemId)->save()` *(Callable against a user only)*
 - Delete: `viewed($itemId)->delete()` *(Callable against a user only)*

### Purchases

 - Get: `purchases()->get()` *(Callable against a user or item)*
 - Create: `purchased($itemId)->save()` *(Callable against a user only)*
 - Delete: `purchased($itemId)->delete()` *(Callable against a user only)*

### Ratings

 - Get: `ratings()->get()` *(Callable against a user or item)*
 - Create: `rated($itemId, $value)->save()` *(Callable against a user only)*
 - Delete: `rated($itemId, $value)->delete()` *(Callable against a user only)*

### Cart Additions

 - Get: `cart()->get()` *(Callable against a user or item)*
 - Create: `carted($itemId)->save()` *(Callable against a user only)*
 - Delete: `carted($itemId)->delete()` *(Callable against a user only)*

### Bookmarks

 - Get: `bookmarks()->get()` *(Callable against a user or item)*
 - Create: `bookmarked($itemId)->save()` *(Callable against a user only)*
 - Delete: `bookmarked($itemId)->delete()` *(Callable against a user only)*

### View Portions

 - Get: `viewPortions()->get()` *(Callable against a user or item)*
 - Create: `viewedPortion($itemId, $value)->save()` *(Callable against a user only)*
 - Delete: `viewedPortion($itemId, $value)->delete()` *(Callable against a user only)*

## Reset Database

This package offers two ways of resetting your Recombee database, first is via `recombee:reset` Artisan command and the other is programmatically by calling the `reset` method on the facade.

> Warning. Resetting your database is irreversible.

### Reset via Artisan Command
```bash
php artisan recombee:reset
```

### Reset via Programmatically
```php
Recombee::reset();
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
