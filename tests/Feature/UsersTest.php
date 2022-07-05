<?php

use Baron\Recombee\Facades\Recombee;
use Baron\Recombee\Support\UserCollection;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\ListUsers;

it('can list users', function () {
    $output = [
        [
            'name' => 'John Doe',
            'userId' => '1',
        ],
    ];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(ListUsers::class)
        ->andReturn($output);

    $results = Recombee::users()->get();

    expect($results instanceof UserCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($output);
});
