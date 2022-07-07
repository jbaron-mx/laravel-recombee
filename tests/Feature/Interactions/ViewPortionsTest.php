<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddRating;
use Recombee\RecommApi\Requests\DeleteRating;
use Recombee\RecommApi\Requests\DeleteViewPortion;
use Recombee\RecommApi\Requests\ListItemRatings;
use Recombee\RecommApi\Requests\ListItemViewPortions;
use Recombee\RecommApi\Requests\ListUserRatings;
use Recombee\RecommApi\Requests\ListUserViewPortions;
use Recombee\RecommApi\Requests\SetViewPortion;

it('can set a viewed portion of given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new SetViewPortion("2", "509", 0.5)))
        ->andReturn('ok');

    $results = Recombee::for(2)->viewedPortion(509, 0.5)->save();

    expect($results)->toBeTrue();
});

it('can delete all viewed portions of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new DeleteViewPortion("2", "509")))
        ->andReturn('ok');

    $results = Recombee::for(2)->viewedPortion(509)->delete();

    expect($results)->toBeTrue();
});

it('can list all the view portions ever submitted by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '2',
        'portion' => 0.5,
        'timestamp' => 1634971162,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListUserViewPortions("2")))
        ->andReturn($interactions);

    $results = Recombee::for(2)->viewPortions()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});

it('can list all the view portions of an item ever submitted by different users', function () {
    $interactions = [[
        'userId' => '2',
        'itemId' => '509',
        'portion' => 0.5,
        'timestamp' => 1634971162,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListItemViewPortions("509")))
        ->andReturn($interactions);

    $results = Recombee::for(new Item(['id' => 509]))->viewPortions()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});
