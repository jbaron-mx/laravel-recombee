<?php

namespace Baron\Recombee\Actions\Interactions\Views;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\AddDetailView as ApiRequest;

class AddDetailView extends Action
{
    public function execute()
    {
        return $this->mapAsBoolean($this->query());
    }

    protected function buildApiRequest()
    {
        return new ApiRequest(
            $this->builder->getInitiator()->getId(),
            $this->builder->getTarget()->getId(),
            $this->builder->prepareOptions()
        );
    }
}
