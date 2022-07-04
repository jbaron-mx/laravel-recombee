<?php

use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;

return [

    'user' => User::class,
    'item' => Item::class,

    'database' => env('RECOMBEE_DATABASE', 'ytunieve-dev'),
    'secret' => env('RECOMBEE_SECRET', 'YL5ikGCiexMF0jfSwWh3qJtwg0YDY7XzNUyTGkQNEIavHgHrBExkwVWfVuAx8AUM'),

];
