<?php

use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\ResetDatabase;

it('can run reset command', function () {
    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ResetDatabase()))
        ->andReturn('ok');

    $this->artisan('recombee:reset')->assertExitCode(0);
});
