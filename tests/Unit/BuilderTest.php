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