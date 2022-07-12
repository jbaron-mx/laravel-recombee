<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Actions\CreateAndDeleteProperties;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\AddItemProperty as ApiRequest;

class AddItemProperties extends CreateAndDeleteProperties
{
    protected function generateBatch(Collection $properties)
    {
        return $properties->map(fn ($type, $name) => new ApiRequest($name, $type))->values()->all();
    }
}
