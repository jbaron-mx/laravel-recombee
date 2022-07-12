<?php

use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;
use Hamcrest\Matchers;
use Illuminate\Support\Arr;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddItemProperty;
use Recombee\RecommApi\Requests\AddUserProperty;
use Recombee\RecommApi\Requests\Batch;
use Recombee\RecommApi\Requests\SetItemValues;
use Recombee\RecommApi\Requests\SetUserValues;

it('can run import command', function () {
    $userModels = User::factory()->count(3)->create();
    $itemModels = Item::factory()->count(3)->create();

    $userProperties = [
        new AddUserProperty('name', 'string'),
        new AddUserProperty('active', 'boolean'),
    ];
    $itemProperties = [
        new AddItemProperty('name', 'string'),
        new AddItemProperty('price', 'double'),
        new AddItemProperty('active', 'boolean'),
    ];
    $users = $userModels->map(
        fn ($model) => new SetUserValues($model->id, Arr::except($model->toArray(), 'id'), ['cascadeCreate' => true])
    )->all();
    $items = $itemModels->map(
        fn ($model) => new SetItemValues($model->id, Arr::except($model->toArray(), 'id'), ['cascadeCreate' => true])
    )->all();

    $mock = $this->mock(Client::class);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($userProperties)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($users)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($itemProperties)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($items)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $this->artisan('recombee:import')->assertExitCode(0);
});

it('can run import command only users', function () {
    $userModels = User::factory()->count(3)->create();

    $userProperties = [
        new AddUserProperty('name', 'string'),
        new AddUserProperty('active', 'boolean'),
    ];
    $users = $userModels->map(
        fn ($model) => new SetUserValues($model->id, Arr::except($model->toArray(), 'id'), ['cascadeCreate' => true])
    )->all();

    $mock = $this->mock(Client::class);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($userProperties)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($users)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $this->artisan('recombee:import -u')->assertExitCode(0);
});

it('can run import command only items', function () {
    $itemModels = Item::factory()->count(3)->create();

    $itemProperties = [
        new AddItemProperty('name', 'string'),
        new AddItemProperty('price', 'double'),
        new AddItemProperty('active', 'boolean'),
    ];
    $items = $itemModels->map(
        fn ($model) => new SetItemValues($model->id, Arr::except($model->toArray(), 'id'), ['cascadeCreate' => true])
    )->all();

    $mock = $this->mock(Client::class);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($itemProperties)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($items)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $this->artisan('recombee:import -i')->assertExitCode(0);
});
