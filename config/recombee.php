<?php

use Baron\Recombee\Tests\Fixtures\Item;
use Baron\Recombee\Tests\Fixtures\User;

return [

    'user' => User::class,
    'item' => Item::class,

    'database' => env('RECOMBEE_DATABASE', 'ytunieve-dev'),
    'token' => env('RECOMBEE_TOKEN', 'r9ScVmKMe4EjlQoejqQmthiKcuINkSvLJOXQkO6GTxCkiLpoUF5RGAlDgdlJCs88'),
    'region' => env('RECOMBEE_REGION', 'us-west'),

];
