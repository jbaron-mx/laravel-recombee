<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\GetItemValues as ApiRequest;

class GetItemValues
{
    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->builder->engine()->client()->send(new ApiRequest(
            $this->builder->getInitiator()->getId()
        ));
    }
}
