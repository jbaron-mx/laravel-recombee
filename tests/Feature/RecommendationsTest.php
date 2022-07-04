<?php

use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Support\RecommendationCollection;
use Baron\Recombee\Tests\Fixtures\Item;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\RecommendItemsToItem;
use Recombee\RecommApi\Requests\RecommendItemsToUser;

it('can recommend items to user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(RecommendItemsToUser::class)
        ->andReturn([
            'recomms' => [
                ['id' => '111'],
                ['id' => '222'],
            ],
        ]);

    $results = Recombee::for(1)->recommendItems()->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toBe(['111', '222']);
});

it('can recommend items to item', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(RecommendItemsToItem::class)
        ->andReturn([
            'recomms' => [
                ['id' => '111'],
                ['id' => '222'],
            ],
        ]);

    $results = Recombee::for(new Item(['id' => 505]))
        ->recommendItems()
        ->get();

    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toBe(['111', '222']);
});
