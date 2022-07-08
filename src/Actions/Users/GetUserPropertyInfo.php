<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\GetUserPropertyInfo as ApiRequest;

class GetUserPropertyInfo
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
