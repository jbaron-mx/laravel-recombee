<?php

use Baron\Recombee\Collection\ItemCollection;
use Baron\Recombee\Collection\PropertyCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Hamcrest\Matchers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddItemProperty;
use Recombee\RecommApi\Requests\Batch;
use Recombee\RecommApi\Requests\DeleteItem;
use Recombee\RecommApi\Requests\DeleteItemProperty;
use Recombee\RecommApi\Requests\GetItemPropertyInfo;
use Recombee\RecommApi\Requests\GetItemValues;
use Recombee\RecommApi\Requests\ListItemProperties;
use Recombee\RecommApi\Requests\ListItems;
use Recombee\RecommApi\Requests\SetItemValues;

it('can retrieve a single item', function () {
    $prop = ['name' => 'HD Monitor', 'active' => true];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new GetItemValues('1')))
        ->andReturn($prop);

    $results = Recombee::item(1)->get();

    expect($results)->toEqual($prop);
});

it('can list all items', function () {
    $items = [
        ['name' => 'HD Monitor', 'itemId' => '1'],
        ['name' => 'Power Bank', 'itemId' => '2'],
    ];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListItems(['returnProperties' => true])))
        ->andReturn($items);

    $results = Recombee::item()->get();

    expect($results instanceof ItemCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($items);
});

it('can paginate items', function () {
    $items = [
        ['name' => 'HD Monitor', 'itemId' => '1'],
        ['name' => 'Power Bank', 'itemId' => '2'],
    ];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListItems([
            'returnProperties' => true,
            'count' => 2,
        ])))
        ->andReturn($items);

    $results = Recombee::item()->paginate(2);

    expect($results instanceof Paginator)->toBeTrue();
    expect($results->items())->toEqual($items);
});

it('can create a plain item with no values', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new SetItemValues('1', [], ['cascadeCreate' => true])))
        ->andReturn('ok');

    $results = Recombee::item(1)->recommendable();

    expect($results)->toBeTrue();
});

it('can create a plain item with some values', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new SetItemValues('1', ['name' => 'HD Monitor'], ['cascadeCreate' => true])))
        ->andReturn('ok');

    $results = Recombee::item(1, ['name' => 'HD Monitor'])->recommendable();

    expect($results)->toBeTrue();
});

it('can delete an item', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new DeleteItem('1')))
        ->andReturn('ok');

    $results = Recombee::item(1)->unrecommendable();

    expect($results)->toBeTrue();
});

it('can create an item property with default type as string', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new Batch([new AddItemProperty('color', 'string')])))
        ->andReturn('ok');

    $results = Recombee::item()->property('color')->save();

    expect($results)->toEqual(['success' => true, 'errors' => []]);
});

it('can create an item property with custom type', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new Batch([new AddItemProperty('active', 'boolean')])))
        ->andReturn('ok');

    $results = Recombee::item()->property('active', 'boolean')->save();

    expect($results)->toEqual(['success' => true, 'errors' => []]);
});

it('can retrieve an item property', function () {
    $prop = ['name' => 'active', 'type' => 'boolean'];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new GetItemPropertyInfo('active')))
        ->andReturn($prop);

    $results = Recombee::item()->property('active')->get();

    expect($results)->toEqual($prop);
});

it('can retrieve all item properties', function () {
    $props = [
        ['name' => 'name', 'type' => 'string'],
        ['name' => 'active', 'type' => 'boolean'],
    ];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListItemProperties()))
        ->andReturn($props);

    $results = Recombee::item()->properties()->get();

    expect($results instanceof PropertyCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($props);
});

it('can create multiple item properties', function () {
    $props = ['name', 'color', 'active' => 'boolean'];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new Batch([
            new AddItemProperty('name', 'string'),
            new AddItemProperty('color', 'string'),
            new AddItemProperty('active', 'boolean'),
        ])))
        ->andReturn([
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
        ]);

    $results = Recombee::item()->properties($props)->save();

    expect($results)->toEqual(['success' => true, 'errors' => []]);
});

it('can delete multiple item properties', function () {
    $props = ['name', 'color', 'active'];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new Batch([
            new DeleteItemProperty('name'),
            new DeleteItemProperty('color'),
            new DeleteItemProperty('active'),
        ])))
        ->andReturn([
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
        ]);

    $results = Recombee::item()->properties($props)->delete();

    expect($results)->toEqual(['success' => true, 'errors' => []]);
});

it('can index all item models', function () {
    $items = Item::factory()->count(3)->create();
    $items = $items->map(function ($model) {
        return new SetItemValues(
            $model->id,
            Arr::except($model->toArray(), 'id'),
            ['cascadeCreate' => true]
        );
    })->all();
    $properties = collect(['name' => 'string', 'price' => 'double', 'active' => 'boolean']);
    $properties = $properties->map(function ($type, $name) {
        return new AddItemProperty($name, $type);
    })->values()->all();

    $mock = $this->mock(Client::class);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($properties)))
        ->andReturn([
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
        ]);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($items)))
        ->andReturn([
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
        ]);

    $response = Item::makeAllRecommendable();

    expect($response)->toBe([
        'properties' => ['success' => true, 'errors' => []],
        'items' => ['success' => true, 'errors' => []],
    ]);
});

it('can index a single item', function () {
    $item = Item::factory()->create(['id' => 11]);
    $properties = [
        new AddItemProperty('name', 'string'),
        new AddItemProperty('price', 'double'),
        new AddItemProperty('active', 'boolean'),
    ];
    $items = [new SetItemValues(
        $item->id, 
        ['name' => $item->name, 'price' => $item->price, 'active' => $item->active], 
        ['cascadeCreate' => true]
    )];

    $mock = $this->mock(Client::class);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($properties)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $mock->shouldReceive('send')
        ->ordered()
        ->once()
        ->with(Matchers::equalTo(new Batch($items)))
        ->andReturn([['code' => 201, 'json' => 'ok']]);

    $response = $item->recommendable();

    expect($response)->toBe([
        'properties' => ['success' => true, 'errors' => []],
        'items' => ['success' => true, 'errors' => []],
    ]);
});
