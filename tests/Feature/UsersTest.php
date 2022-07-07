<?php

use Baron\Recombee\Collection\UserCollection;
use Baron\Recombee\Facades\Recombee;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\ListUsers;
use Recombee\RecommApi\Requests\SetUserValues;

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
