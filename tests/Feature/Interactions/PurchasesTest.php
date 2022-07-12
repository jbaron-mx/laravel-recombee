<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddPurchase;
use Recombee\RecommApi\Requests\DeletePurchase;
use Recombee\RecommApi\Requests\ListItemPurchases;
use Recombee\RecommApi\Requests\ListUserPurchases;

beforeEach(function () {
    User::factory()->create(['id' => 1]);
    Item::factory()->create(['id' => 509]);

    $this->m = $this->mock(Client::class)
        ->shouldReceive('send')
        ->twice();
});

it('can add a purchase of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new AddPurchase(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->purchased(509)->save();
    $modelResults = User::first()->purchased(509)->save();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can delete all purchases of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new DeletePurchase(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->purchased(509)->delete();
    $modelsResults = User::first()->purchased(509)->delete();

    expect($facadeResults)->toBeTrue();
    expect($modelsResults)->toBeTrue();
});

it('can list all purchases made by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'timestamp' => 1634971162,
        'amount' => 1.0,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListUserPurchases(1)))
        ->andReturn($interactions);

    $facadeResults = Recombee::user(1)->purchases()->get();
    $modelResults = User::first()->purchases()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});

it('can list all the ever-made purchases of a given item', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'timestamp' => 1634971162,
        'amount' => 1.0,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListItemPurchases("509")))
        ->andReturn($interactions);

    $facadeResults = Recombee::item(509)->purchases()->get();
    $modelResults = Item::first()->purchases()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});
