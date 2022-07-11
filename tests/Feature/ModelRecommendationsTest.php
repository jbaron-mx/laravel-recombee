<?php

use Baron\Recombee\Collection\RecommendationCollection;
use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\RecommendItemsToItem;
use Recombee\RecommApi\Requests\RecommendItemsToUser;
use Recombee\RecommApi\Requests\RecommendNextItems;
use Recombee\RecommApi\Requests\RecommendUsersToItem;
use Recombee\RecommApi\Requests\RecommendUsersToUser;

it('can recommend items to user using model', function () {
    $user = User::factory()->create();

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new RecommendItemsToUser($user->id, 25, ['returnProperties' => true])))
        ->andReturn(['recomms' => []]);

    $results = User::first()->recommendItems()->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toEqual([]);
});

it('can recommend next items to user using model', function () {
    $user = User::factory()->create();

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new RecommendNextItems('abcd1234id', 25)))
        ->andReturn(['recomms' => []]);

    $results = User::first()->recommendItems('abcd1234id')->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toEqual([]);
});

it('can recommend items to item using model', function () {
    $item = Item::factory()->create();

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new RecommendItemsToItem($item->id, null, 25, ['returnProperties' => true])))
        ->andReturn(['recomms' => []]);

    $results = Item::first()->recommendItems()->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toEqual([]);
});

it('can recommend next items to item using model', function () {
    $item = Item::factory()->create();

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new RecommendNextItems('abcd1234id', 25)))
        ->andReturn(['recomms' => []]);

    $results = Item::first()->recommendItems('abcd1234id')->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toEqual([]);
});

it('can recommend users to user using model', function () {
    $user = User::factory()->create();

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new RecommendUsersToUser($user->id, 25, ['returnProperties' => true])))
        ->andReturn(['recomms' => []]);

    $results = User::first()->recommendUsers()->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toEqual([]);
});

it('can recommend users to item using model', function () {
    $item = Item::factory()->create();

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new RecommendUsersToItem($item->id, 25, ['returnProperties' => true])))
        ->andReturn(['recomms' => []]);

    $results = Item::first()->recommendUsers()->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toEqual([]);
});
