<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddDetailView;
use Recombee\RecommApi\Requests\DeleteDetailView;
use Recombee\RecommApi\Requests\ListItemDetailViews;
use Recombee\RecommApi\Requests\ListUserDetailViews;

beforeEach(function () {
    User::factory()->create(['id' => 1]);
    Item::factory()->create(['id' => 509]);

    $this->m = $this->mock(Client::class)
        ->shouldReceive('send')
        ->twice();
});

it('can add a detail view of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new AddDetailView(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->viewed(509)->save();
    $modelResults = User::first()->viewed(509)->save();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can delete all detail views of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new DeleteDetailView(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->viewed(509)->delete();
    $modelResults = User::first()->viewed(509)->delete();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can list all detail views made by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'timestamp' => 1634971162,
        'duration' => null,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListUserDetailViews(1)))
        ->andReturn($interactions);

    $facadeResults = Recombee::user(1)->views()->get();
    $modelResults = User::first()->views()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});

it('can list all the detail views of a given item ever made by different users', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'timestamp' => 1634971162,
        'duration' => null,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListItemDetailViews(509)))
        ->andReturn($interactions);

    $facadeResults = Recombee::item(509)->views()->get();
    $modelResults = Item::first()->views()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});
