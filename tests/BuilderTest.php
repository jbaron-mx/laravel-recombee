<?php

use Baron\Recombee\Support\Entity;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Support\RecommendationCollection;
use Baron\Recombee\Tests\Fixtures\User;
use Recombee\RecommApi\Client;

it('can set initiator as model', function () {
    $builder = Recombee::for(new User(['id' => 9]));
    expect($builder->getInitiator() instanceof Entity)->toBeTrue();
    expect($builder->getInitiator()->getId())->toBe('9');
});

it('can set initiator as string', function () {
    $builder = Recombee::for('17');
    expect($builder->getInitiator() instanceof Entity)->toBeTrue();
    expect($builder->getInitiator()->getId())->toBe('17');
});

it('can recommend items to user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->andReturn([
            'recomms' => [
                ['id' => '111'],
                ['id' => '222'],
            ]
        ]);
    
    $results = Recombee::for(1)->recommendItems()->get();
    
    expect($results instanceof RecommendationCollection)->toBeTrue();
    expect($results->collection->all())->toBe(['111', '222']);
});