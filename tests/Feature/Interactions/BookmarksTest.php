<?php

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Tests\Fixtures\Item;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddBookmark;
use Recombee\RecommApi\Requests\DeleteBookmark;
use Recombee\RecommApi\Requests\ListItemBookmarks;
use Recombee\RecommApi\Requests\ListUserBookmarks;

it('can add a bookmark of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new AddBookmark("2", "509")))
        ->andReturn('ok');

    $results = Recombee::for(2)->bookmarked(509)->save();

    expect($results)->toBeTrue();
});

it('can delete all bookmarks of a given item made by a given user', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new DeleteBookmark("2", "509")))
        ->andReturn('ok');

    $results = Recombee::for(2)->bookmarked(509)->delete();

    expect($results)->toBeTrue();
});

it('can list all bookmarks made by a given user', function () {
    $interactions = [[
        'itemId' => '509',
        'userId' => '1',
        'timestamp' => 1634971162,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListUserBookmarks("2")))
        ->andReturn($interactions);

    $results = Recombee::for(2)->bookmarks()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});

it('can list all the ever-made bookmarks of a given item', function () {
    $interactions = [[
        'userId' => '1',
        'itemId' => '509',
        'timestamp' => 1634971162,
    ]];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListItemBookmarks("509")))
        ->andReturn($interactions);

    $results = Recombee::for(new Item(['id' => 509]))->bookmarks()->get();

    expect($results instanceof InteractionCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($interactions);
});
