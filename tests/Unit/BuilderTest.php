<?php

use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Support\Entity;
use Baron\Recombee\Tests\Fixtures\User;

it('can set initiator as user from a user model', function () {
    $builder = Recombee::user(new User(['id' => 9]));
    expect($builder->getInitiator() instanceof Entity)->toBeTrue();
    expect($builder->getInitiator()->getId())->toBe('9');
    expect($builder->getInitiator()->getType())->toBe(Entity::USER);
});

it('can set initiator as user from a string', function () {
    $builder = Recombee::user('17');
    expect($builder->getInitiator() instanceof Entity)->toBeTrue();
    expect($builder->getInitiator()->getId())->toBe('17');
    expect($builder->getInitiator()->getType())->toBe(Entity::USER);
});

it('can set initiator as item from a item model', function () {
    $builder = Recombee::item(509);
    expect($builder->getInitiator() instanceof Entity)->toBeTrue();
    expect($builder->getInitiator()->getId())->toBe('509');
    expect($builder->getInitiator()->getType())->toBe(Entity::ITEM);
});

it('can set initiator as item from a string', function () {
    $builder = Recombee::item('17');
    expect($builder->getInitiator() instanceof Entity)->toBeTrue();
    expect($builder->getInitiator()->getId())->toBe('17');
    expect($builder->getInitiator()->getType())->toBe(Entity::ITEM);
});

it('can define a target user', function () {
    $builder = Recombee::seenBy(new User(['id' => 123]));
    expect($builder->param('targetUserId'))->toBe('123');
});

it('can define a query limit', function () {
    $builder = Recombee::take(50);
    expect($builder->param('count'))->toBe(50);
});

it('wont return any additional properties', function () {
    $builder = Recombee::select();
    expect($builder->option('returnProperties'))->toBeNull();
    expect($builder->option('includedProperties'))->toBeNull();
});

it('will return selected properties only', function () {
    $builder = Recombee::select('brand', 'category');
    expect($builder->option('returnProperties'))->toBeTrue();
    expect($builder->option('includedProperties'))->toEqual('brand,category');
});
