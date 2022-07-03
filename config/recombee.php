<?php

return [

    'models' => [
        'user' => App\Models\User::class,
        'item' => App\Models\Product::class,
    ],

    'database' => env('RECOMBEE_DATABASE', 'ytunieve-dev'),
    'secret' => env('RECOMBEE_SECRET', 'YL5ikGCiexMF0jfSwWh3qJtwg0YDY7XzNUyTGkQNEIavHgHrBExkwVWfVuAx8AUM'),

];
