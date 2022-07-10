<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\CreateAndDeleteProperties;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\AddUserProperty as ApiRequest;

class AddUserProperties extends CreateAndDeleteProperties
{
    protected function generateBatch(Collection $properties)
    {
        return $properties->map(fn ($type, $name) => new ApiRequest($name, $type))->values()->all();
    }
}
