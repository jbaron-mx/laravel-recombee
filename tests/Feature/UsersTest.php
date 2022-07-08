<?php

use Baron\Recombee\Collection\PropertyCollection;
use Baron\Recombee\Collection\UserCollection;
use Baron\Recombee\Facades\Recombee;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddUserProperty;
use Recombee\RecommApi\Requests\Batch;
use Recombee\RecommApi\Requests\DeleteUser;
use Recombee\RecommApi\Requests\DeleteUserProperty;
use Recombee\RecommApi\Requests\GetUserPropertyInfo;
use Recombee\RecommApi\Requests\GetUserValues;
use Recombee\RecommApi\Requests\ListUserProperties;
use Recombee\RecommApi\Requests\ListUsers;
use Recombee\RecommApi\Requests\SetUserValues;

it('can retrieve a single user', function () {
    $prop = ['name' => 'John Doe', 'active' => true];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new GetUserValues('1')))
        ->andReturn($prop);

    $results = Recombee::user(1)->get();

    expect($results)->toEqual($prop);
});

it('can list users', function () {
    $users = [
        [
            'name' => 'John Doe',
            'userId' => '1',
        ],
    ];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListUsers(['returnProperties' => true])))
        ->andReturn($users);

    $results = Recombee::users()->get();

    expect($results instanceof UserCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($users);
});

it('can create a plain user with no values', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new SetUserValues('1', [], ['cascadeCreate' => true])))
        ->andReturn('ok');

    $results = Recombee::user(1)->recommendable();

    expect($results)->toBeTrue();
});

it('can create a plain user with some values', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new SetUserValues('1', ['name' => 'John Doe'], ['cascadeCreate' => true])))
        ->andReturn('ok');

    $results = Recombee::user(1, ['name' => 'John Doe'])->recommendable();

    expect($results)->toBeTrue();
});

it('can delete a user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new DeleteUser('1')))
        ->andReturn('ok');

    $results = Recombee::user(1)->unrecommendable();

    expect($results)->toBeTrue();
});

it('can create a user property with default type as string', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new Batch([
            new AddUserProperty('name', 'string'),
        ])))
        ->andReturn('ok');

    $results = Recombee::user()->property('name')->save();

    expect($results)->toEqual(['success' => true, 'errors' => []]);
});

it('can create a user property with custom type', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new Batch([
            new AddUserProperty('active', 'boolean'),
        ])))
        ->andReturn('ok');

    $results = Recombee::user()->property('active', 'boolean')->save();

    expect($results)->toEqual(['success' => true, 'errors' => []]);
});

it('can retrieve a user property', function () {
    $prop = ['name' => 'active', 'type' => 'boolean'];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new GetUserPropertyInfo('active')))
        ->andReturn($prop);

    $results = Recombee::user()->property('active')->get();

    expect($results)->toEqual($prop);
});

it('can retrieve all user properties', function () {
    $props = [
        ['name' => 'name', 'type' => 'string'],
        ['name' => 'active', 'type' => 'boolean'],
    ];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListUserProperties()))
        ->andReturn($props);

    $results = Recombee::user()->properties()->get();

    expect($results instanceof PropertyCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($props);
});

it('can create multiple user properties', function () {
    $props = ['name', 'city', 'active' => 'boolean'];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new Batch([
            new AddUserProperty('name', 'string'),
            new AddUserProperty('city', 'string'),
            new AddUserProperty('active', 'boolean'),
        ])))
        ->andReturn([
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
        ]);

    $results = Recombee::user()->properties($props)->save();

    expect($results)->toEqual(['success' => true, 'errors' => []]);
});

it('can delete multiple user properties', function () {
    $props = ['name', 'city', 'active'];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new Batch([
            new DeleteUserProperty('name', 'string'),
            new DeleteUserProperty('city', 'string'),
            new DeleteUserProperty('active', 'boolean'),
        ])))
        ->andReturn([
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
            ['code' => 201, 'json' => 'ok'],
        ]);

    $results = Recombee::user()->properties($props)->delete();

    expect($results)->toEqual(['success' => true, 'errors' => []]);
});
