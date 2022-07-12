<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddRating;
use Recombee\RecommApi\Requests\DeleteRating;
use Recombee\RecommApi\Requests\ListItemRatings;
use Recombee\RecommApi\Requests\ListUserRatings;

beforeEach(function () {
    User::factory()->create(['id' => 1]);
    Item::factory()->create(['id' => 509]);

    $this->m = $this->mock(Client::class)
        ->shouldReceive('send')
        ->twice();
});

it('can add a rating of given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new AddRating(1, 509, 0.5)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->rated(509, 0.5)->save();
    $modelResults = User::first()->rated(509, 0.5)->save();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can delete all ratings of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new DeleteRating(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->rated(509)->delete();
    $modelResults = User::first()->rated(509)->delete();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can list all the ratings ever submitted by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'rating' => 0.5,
        'timestamp' => 1634971162,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListUserRatings(1)))
        ->andReturn($interactions);

    $facadeResults = Recombee::user(1)->ratings()->get();
    $modelResults = User::first()->ratings()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});

it('can list all the ratings of an item ever submitted by different users', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'rating' => 0.5,
        'timestamp' => 1634971162,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListItemRatings(509)))
        ->andReturn($interactions);

    $facadeResults = Recombee::item(509)->ratings()->get();
    $modelResults = Item::first()->ratings()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});
