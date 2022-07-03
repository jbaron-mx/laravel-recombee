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

it('can get id from model', function () {
    $entity = new Entity(new User(['id' => 22]));
    expect($entity->getId())->toBe('22');
});

it('can get id from string', function () {
    $entity = new Entity('66');
    expect($entity->getId())->toBe('66');
});

it('can get key name', function () {
    $entity = new Entity(new User());
    expect($entity->getKeyName())->toBe('id');
});