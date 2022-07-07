<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddDetailView;
use Recombee\RecommApi\Requests\DeleteDetailView;
use Recombee\RecommApi\Requests\ListItemDetailViews;
use Recombee\RecommApi\Requests\ListUserDetailViews;

it('can add a detail view of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new AddDetailView("2", "509")))
        ->andReturn('ok');

    $results = Recombee::user(2)->viewed(509)->save();

    expect($results)->toBeTrue();
});

it('can delete all detail views of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new DeleteDetailView("2", "509")))
        ->andReturn('ok');

    $results = Recombee::user(2)->viewed(509)->delete();

    expect($results)->toBeTrue();
});

it('can list all detail views made by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'timestamp' => 1634971162,
        'duration' => null,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListUserDetailViews("1")))
        ->andReturn($interactions);

    $results = Recombee::user(1)->views()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});

it('can list all the detail views of a given item ever made by different users', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'timestamp' => 1634971162,
        'duration' => null,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListItemDetailViews("509")))
        ->andReturn($interactions);

    $results = Recombee::item(509)->views()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});
