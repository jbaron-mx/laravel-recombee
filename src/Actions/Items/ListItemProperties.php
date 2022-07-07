<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Builder;
use Baron\Recombee\Collection\PropertyCollection;
use Recombee\RecommApi\Requests\ListItemProperties as ApiRequest;

class ListItemProperties
{
    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->map(
            $this->builder->engine()->client()->send(new ApiRequest())
        );
    }

    public function map($results): PropertyCollection
    {
        return new PropertyCollection($results);
    }
}
