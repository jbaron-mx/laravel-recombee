<?php

use Baron\Recombee\Facades\Recombee;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\DeleteItem;
use Recombee\RecommApi\Requests\SetItemValues;

it('can create a plain item with no values', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new SetItemValues('1', [], ['cascadeCreate' => true])))
        ->andReturn('ok');

    $results = Recombee::item(1)->recommendable();

    expect($results)->toBeTrue();
});

it('can create a plain item with some values', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new SetItemValues('1', ['name' => 'HD Monitor'], ['cascadeCreate' => true])))
        ->andReturn('ok');

    $results = Recombee::item(1, ['name' => 'HD Monitor'])->recommendable();

    expect($results)->toBeTrue();
});

it('can delete an item', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new DeleteItem('1')))
        ->andReturn('ok');

    $results = Recombee::item(1)->unrecommendable();

    expect($results)->toBeTrue();
});
