<?php

use Baron\Recombee\Collection\RecommendationCollection;
use Baron\Recombee\Facades\Recombee;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\RecommendItemsToItem;
use Recombee\RecommApi\Requests\RecommendItemsToUser;

it('can recommend items to user', function () {
    $items = [
        ['id' => '111'],
        ['id' => '222'],
    ];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new RecommendItemsToUser("1", null, ['returnProperties' => true])))
        ->andReturn(['recomms' => $items]);

    $results = Recombee::user(1)->recommendItems()->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($items);
});

it('can recommend items to item', function () {
    $items = [
        ['id' => '111'],
        ['id' => '222'],
    ];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new RecommendItemsToItem("509", null, null, ['returnProperties' => true])))
        ->andReturn(['recomms' => $items]);

    $results = Recombee::item(509)->recommendItems()->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($items);
});
