<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\DeleteViewPortion;
use Recombee\RecommApi\Requests\ListItemViewPortions;
use Recombee\RecommApi\Requests\ListUserViewPortions;
use Recombee\RecommApi\Requests\SetViewPortion;

beforeEach(function () {
    User::factory()->create(['id' => 1]);
    Item::factory()->create(['id' => 509]);

    $this->m = $this->mock(Client::class)
        ->shouldReceive('send')
        ->twice();
});

it('can set a viewed portion of given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new SetViewPortion(1, 509, 0.5)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->viewedPortion(509, 0.5)->save();
    $modelResults = User::first()->viewedPortion(509, 0.5)->save();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can delete all viewed portions of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new DeleteViewPortion(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->viewedPortion(509)->delete();
    $modelResults = User::first()->viewedPortion(509)->delete();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can list all the view portions ever submitted by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '2',
        'portion' => 0.5,
        'timestamp' => 1634971162,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListUserViewPortions(1)))
        ->andReturn($interactions);

    $facadeResults = Recombee::user(1)->viewPortions()->get();
    $modelResults = User::first()->viewPortions()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});

it('can list all the view portions of an item ever submitted by different users', function () {
    $interactions = [[
        'userId' => '2',
        'itemId' => '509',
        'portion' => 0.5,
        'timestamp' => 1634971162,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListItemViewPortions("509")))
        ->andReturn($interactions);

    $facadeResults = Recombee::item(509)->viewPortions()->get();
    $modelResults = Item::first()->viewPortions()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});
