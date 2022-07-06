<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddCartAddition;
use Recombee\RecommApi\Requests\DeleteCartAddition;
use Recombee\RecommApi\Requests\ListItemCartAdditions;
use Recombee\RecommApi\Requests\ListUserCartAdditions;

it('can add a cart addition of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new AddCartAddition("2", "509")))
        ->andReturn('ok');

    $results = Recombee::for(2)->addedToCart(509)->save();

    expect($results)->toBeTrue();
});

it('can delete all cart additions of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new DeleteCartAddition("2", "509")))
        ->andReturn('ok');

    $results = Recombee::for(2)->addedToCart(509)->delete();

    expect($results)->toBeTrue();
});

it('can list all cart additions made by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'timestamp' => 1634971162,
        'amount' => 1.0,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListUserCartAdditions("1")))
        ->andReturn($interactions);

    $results = Recombee::for(1)->cart()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});

it('can list all the ever-made cart additions of a given item', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'timestamp' => 1634971162,
        'amount' => 1.0,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListItemCartAdditions("509")))
        ->andReturn($interactions);

    $results = Recombee::for(new Item(['id' => 509]))->cart()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});
