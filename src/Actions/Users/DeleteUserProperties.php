<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\CreateAndDeleteProperties;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\DeleteUserProperty as ApiRequest;

class DeleteUserProperties extends CreateAndDeleteProperties
{
    protected function generateBatch(Collection $properties)
    {
        return $properties->map(fn ($type, $name) => new ApiRequest($name))->values()->all();
    }
}
