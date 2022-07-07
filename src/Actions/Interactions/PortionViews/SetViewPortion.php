<?php

namespace Baron\Recombee\Actions\Interactions\PortionViews;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\SetViewPortion as ApiRequest;

class SetViewPortion
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
            $this->builder->param('portion'),
            $this->builder->prepareOptions()
        )) === 'ok' ? true : false;
    }
}
