<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddBookmark;
use Recombee\RecommApi\Requests\DeleteBookmark;
use Recombee\RecommApi\Requests\ListItemBookmarks;
use Recombee\RecommApi\Requests\ListUserBookmarks;

beforeEach(function () {
    User::factory()->create(['id' => 1]);
    Item::factory()->create(['id' => 509]);

    $this->m = $this->mock(Client::class)
        ->shouldReceive('send')
        ->twice();
});

it('can add a bookmark of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new AddBookmark(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->bookmarked(509)->save();
    $modelResults = User::first()->bookmarked(509)->save();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can delete all bookmarks of a given item made by a given user', function () {
    $this->m
        ->with(Matchers::equalTo(new DeleteBookmark(1, 509)))
        ->andReturn('ok');

    $facadeResults = Recombee::user(1)->bookmarked(509)->delete();
    $modelResults = User::first()->bookmarked(509)->delete();

    expect($facadeResults)->toBeTrue();
    expect($modelResults)->toBeTrue();
});

it('can list all bookmarks made by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'timestamp' => 1634971162,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListUserBookmarks(1)))
        ->andReturn($interactions);

    $facadeResults = Recombee::user(1)->bookmarks()->get();
    $modelResults = User::first()->bookmarks()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});

it('can list all the ever-made bookmarks of a given item', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'timestamp' => 1634971162,
    ]];

    $this->m
        ->with(Matchers::equalTo(new ListItemBookmarks(509)))
        ->andReturn($interactions);

    $facadeResults = Recombee::item(509)->bookmarks()->get();
    $modelResults = Item::first()->bookmarks()->get();

    expect($facadeResults instanceof InteractionCollection)->toBeTrue();
    expect($facadeResults->collection->all())->toEqual($interactions);

    expect($modelResults instanceof InteractionCollection)->toBeTrue();
    expect($modelResults->collection->all())->toEqual($interactions);
});
