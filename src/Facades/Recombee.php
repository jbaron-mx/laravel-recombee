<?php

namespace Baron\Recombee\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Baron\Recombee\Recombee
 */
class Recombee extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-recombee';
    }
}
