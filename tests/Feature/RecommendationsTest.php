<?php

use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Support\RecommendationCollection;
use Baron\Recombee\Tests\Fixtures\Item;
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
        ->with(RecommendItemsToUser::class)
        ->andReturn([
            'recomms' => $items,
        ]);

    $results = Recombee::for(1)->recommendItems()->get();

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
        ->with(RecommendItemsToItem::class)
        ->andReturn([
            'recomms' => $items,
        ]);

    $results = Recombee::for(new Item(['id' => 505]))
        ->recommendItems()
        ->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($items);
});
