<?php

use Baron\Recombee\Collection\PropertyCollection;
use Baron\Recombee\Facades\Recombee;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddItemProperty;
use Recombee\RecommApi\Requests\DeleteItem;
use Recombee\RecommApi\Requests\GetItemPropertyInfo;
use Recombee\RecommApi\Requests\ListItemProperties;
use Recombee\RecommApi\Requests\SetItemValues;

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
        ->with(Matchers::equalTo(new AddItemProperty('color', 'string')))
        ->andReturn('ok');

    $results = Recombee::item()->property('color')->save();

    expect($results)->toBeTrue();
});

it('can create an item property with custom type', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new AddItemProperty('active', 'boolean')))
        ->andReturn('ok');

    $results = Recombee::item()->property('active', 'boolean')->save();

    expect($results)->toBeTrue();
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
