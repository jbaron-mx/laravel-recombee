<?php

use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Recombee\RecommApi\Requests\AddPurchase;
use Recombee\RecommApi\Requests\DeletePurchase;
use Baron\Recombee\Collection\InteractionCollection;
use Recombee\RecommApi\Requests\ListItemPurchases;
use Recombee\RecommApi\Requests\ListUserPurchases;

it('can add a purchase of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new AddPurchase("2", "509")))
        ->andReturn('ok');

    $results = Recombee::for(2)->purchased(509)->save();

    expect($results)->toBeTrue();
});

it('can delete all purchases of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new DeletePurchase("2", "509")))
        ->andReturn('ok');

    $results = Recombee::for(2)->purchased(509)->delete();

    expect($results)->toBeTrue();
});

it('can list all purchases made by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'timestamp' => 1634971162,
        'amount' => 1.0,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListUserPurchases("1")))
        ->andReturn($interactions);

    $results = Recombee::for(1)->purchases()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});

it('can list all the ever-made purchases of a given item', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'timestamp' => 1634971162,
        'amount' => 1.0,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListItemPurchases("509")))
        ->andReturn($interactions);

    $results = Recombee::for(new Item(['id' => 509]))->purchases()->get();
    
    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});
