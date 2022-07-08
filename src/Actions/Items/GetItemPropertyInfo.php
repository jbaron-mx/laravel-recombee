<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\GetItemPropertyInfo as ApiRequest;

class GetItemPropertyInfo
{
    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->builder->engine()->client()->send(new ApiRequest(
            array_key_first($this->builder->param('properties'))
        ));
    }
}
