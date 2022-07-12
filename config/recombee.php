<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User / Item
    |--------------------------------------------------------------------------
    |
    | These configuration values determine which Eloquent models should be used
    | as your user and item entities that will be synced with your Recombee's
    | database. Typically, the item model refers to products in e-commerce.
    |
    */
    'user' => null, // App\Models\User::class
    'item' => null, // App\Models\Item::class

    /*
    |--------------------------------------------------------------------------
    | Recombee Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Recombee settings. Recombee is a cloud-hosted
    | AI-powered recommendation engine. Just plug in your database name and 
    | authentication token to get started personalizing user experiences.
    |
    */
    'database' => env('RECOMBEE_DATABASE', ''),
    'token' => env('RECOMBEE_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Database's Region
    |--------------------------------------------------------------------------
    |
    | Here you may configure the region that the SDK Client will use to consume
    | the service. You should adjust this to the region that is the closest
    | to you and achieve minimal network latency during the API calls.
    |
    */
    'region' => env('RECOMBEE_REGION', 'us-west'),

];
