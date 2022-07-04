<?php

use Baron\Recombee\Builder;
use Baron\Recombee\Facades\Recombee;
use Recombee\RecommApi\Client;

it('resolves client from the container', function () {
    $client = app(Client::class);

    expect($client instanceof Client)->toBeTrue();
});

it('resolves client as a singleton', function () {
    $clientA = app(Client::class);
    $clientB = app(Client::class);

    expect($clientA)->toBe($clientB);
});

it('resolves facade as builder', function () {
    $builder = Recombee::getFacadeRoot();

    expect($builder instanceof Builder)->toBeTrue();
});
