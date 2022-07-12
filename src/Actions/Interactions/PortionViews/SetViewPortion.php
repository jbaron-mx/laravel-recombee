<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Interactions\PortionViews;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\SetViewPortion as ApiRequest;

class SetViewPortion extends Action
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
            $this->builder->param('portion'),
            $this->builder->prepareOptions()
        );
    }
}
