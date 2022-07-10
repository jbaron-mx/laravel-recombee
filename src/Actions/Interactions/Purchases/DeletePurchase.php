<?php

namespace Baron\Recombee\Actions\Interactions\Purchases;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\DeletePurchase as ApiRequest;

class DeletePurchase extends Action
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
