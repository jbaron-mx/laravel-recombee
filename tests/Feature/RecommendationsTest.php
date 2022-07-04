<?php

use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Support\RecommendationCollection;
use Recombee\RecommApi\Client;

it('can recommend items to user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
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
