<?php

namespace Baron\Recombee\Actions\Interactions\Views;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\AddDetailView as ApiRequest;

class AddDetailView
{
    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->builder->engine()->client()->send(new ApiRequest(
            $this->builder->getInitiator()->getId(),
            $this->builder->getTarget()->getId(),
            $this->builder->prepareOptions()
        )) === 'ok' ? true : false;
    }
}
