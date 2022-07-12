<?php

declare(strict_types=1);

namespace Baron\Recombee\Facades;

use Baron\Recombee\Builder;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Baron\Recombee\Builder user(\Illuminate\Database\Eloquent\Model|string $userId, array $values = null)
 * @method static \Baron\Recombee\Builder item(\Illuminate\Database\Eloquent\Model|string $itemId, array $values = null)
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
