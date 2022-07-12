<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddCartAddition;
use Recombee\RecommApi\Requests\DeleteCartAddition;
use Recombee\RecommApi\Requests\ListItemCartAdditions;
use Recombee\RecommApi\Requests\ListUserCartAdditions;

beforeEach(function () {
    User::factory()->create(['id' => 1]);
    Item::factory()->create(['id' => 509]);

    $this->m = $this->mock(Client::class)
        ->shouldReceive('send')
        ->twice();
});

it('can add a cart addition of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new AddCartAddition(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->carted(509)->save();
    $modelResults = User::first()->carted(509)->save();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can delete all cart additions of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new DeleteCartAddition(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->carted(509)->delete();
    $modelResults = User::first()->carted(509)->delete();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can list all cart additions made by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'timestamp' => 1634971162,
        'amount' => 1.0,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListUserCartAdditions(1)))
        ->andReturn($interactions);

    $facadeResults = Recombee::user(1)->cart()->get();
    $modelResults = User::first()->cart()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});

it('can list all the ever-made cart additions of a given item', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'timestamp' => 1634971162,
        'amount' => 1.0,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListItemCartAdditions(509)))
        ->andReturn($interactions);

    $facadeResults = Recombee::item(509)->cart()->get();
    $modelResults = Item::first()->cart()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});
