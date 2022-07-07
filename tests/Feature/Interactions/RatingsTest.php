<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddRating;
use Recombee\RecommApi\Requests\DeleteRating;
use Recombee\RecommApi\Requests\ListItemRatings;
use Recombee\RecommApi\Requests\ListUserRatings;

it('can add a rating of given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new AddRating("2", "509", 0.5)))
        ->andReturn('ok');

    $results = Recombee::user(2)->rated(509, 0.5)->save();

    expect($results)->toBeTrue();
});

it('can delete all ratings of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new DeleteRating("2", "509")))
        ->andReturn('ok');

    $results = Recombee::user(2)->rated(509)->delete();

    expect($results)->toBeTrue();
});

it('can list all the ratings ever submitted by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'rating' => 0.5,
        'timestamp' => 1634971162,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListUserRatings("1")))
        ->andReturn($interactions);

    $results = Recombee::user(1)->ratings()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});

it('can list all the ratings of an item ever submitted by different users', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'rating' => 0.5,
        'timestamp' => 1634971162,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListItemRatings("509")))
        ->andReturn($interactions);

    $results = Recombee::item(509)->ratings()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});
