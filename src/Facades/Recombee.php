<?php

namespace Baron\Recombee\Facades;

use Baron\Recombee\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Baron\Recombee\Builder
 */
class Recombee extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Builder::class;
    }
}
