<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\AddItemProperty as ApiRequest;

class AddItemProperty
{
    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->builder->engine()->client()->send(new ApiRequest(
            $this->builder->param('propertyName'),
            $this->builder->param('type')
        )) === 'ok' ? true : false;
    }
}
