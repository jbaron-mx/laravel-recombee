<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Actions\CreateAndDeleteProperties;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\DeleteItemProperty as ApiRequest;

class DeleteItemProperties extends CreateAndDeleteProperties
{
    protected function generateBatch(Collection $properties)
    {
        return $properties->map(fn ($type, $name) => new ApiRequest($name))->values()->all();
    }
}
