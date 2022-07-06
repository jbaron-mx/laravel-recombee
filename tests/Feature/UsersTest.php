<?php

use Baron\Recombee\Collection\UserCollection;
use Baron\Recombee\Facades\Recombee;
use Hamcrest\Matchers;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\ListUsers;

it('can list users', function () {
    $users = [
        [
            'name' => 'John Doe',
            'userId' => '1',
        ],
    ];

    $this->mock(Client::class)
        ->shouldReceive('send')
        ->once()
        ->with(Matchers::equalTo(new ListUsers(['returnProperties' => true])))
        ->andReturn($users);

    $results = Recombee::users()->get();

    expect($results instanceof UserCollection)->toBeTrue();
    expect($results->collection->all())->toEqual($users);
});
