<?php

namespace Baron\Recombee\Facades;

use Baron\Recombee\Builder;
use Illuminate\Support\Facades\Facade;


/**
 * @method static \Baron\Recombee\Builder for(\Illuminate\Database\Eloquent\Model|string $initiator)
 * @method static \Baron\Recombee\Builder users()
 * @method static bool reset()
 * 
 * @see \Baron\Recombee\Builder
 */
class Recombee extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Builder::class;
    }
}
