<?php

use Baron\Recombee\Support\Entity;
use Baron\Recombee\Tests\Fixtures\User;

it('can instatiate entity from model', function () {
    $entity = new Entity(new User());
    expect($entity instanceof Entity)->toBeTrue();
});

it('can instatiate entity from string', function () {
    $entity = new Entity('15');
    expect($entity instanceof Entity)->toBeTrue();
});

it('can get id from entity', function () {
    $entity = new Entity(new User(['id' => 22]));
    expect($entity->getId())->toBe('22');
});

it('can get key name from entity', function () {
    $entity = new Entity(new User());
    expect($entity->getKeyName())->toBe('id');
});
