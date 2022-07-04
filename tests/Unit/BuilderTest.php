<?php

use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Support\Entity;
use Baron\Recombee\Tests\Fixtures\User;

it('can set initiator using a model', function () {
    $builder = Recombee::for(new User(['id' => 9]));
    expect($builder->getInitiator() instanceof Entity)->toBeTrue();
    expect($builder->getInitiator()->getId())->toBe('9');
});

it('can set initiator using a string', function () {
    $builder = Recombee::for('17');
    expect($builder->getInitiator() instanceof Entity)->toBeTrue();
    expect($builder->getInitiator()->getId())->toBe('17');
});

it('can define a target user', function () {
    $builder = Recombee::seenBy(new User(['id' => 123]));
    expect($builder->targetUserId)->toBe('123');
});

it('can define a query limit', function () {
    $builder = Recombee::limit(50);
    expect($builder->limit)->toBe(50);
});
