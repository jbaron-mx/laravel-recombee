<?php

use Baron\Recombee\Facades\Recombee;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\ResetDatabase;

it('can reset the database', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ResetDatabase()))
        ->andReturn('ok');

    $results = Recombee::reset();

    expect($results)->toBeTrue();
});
