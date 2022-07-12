<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Interactions\Purchases;

use Baron\Recombee\Actions\Action;
use Baron\Recombee\Collection\InteractionCollection;
use Recombee\RecommApi\Requests\ListUserPurchases as ApiRequest;

class ListUserPurchases extends Action
{
    public function execute()
    {
        return $this->map($this->query());
    }

    protected function buildApiRequest()
    {
        return new ApiRequest(
            $this->builder->getInitiator()->getId()
        );
    }

    protected function map($results): InteractionCollection
    {
        return new InteractionCollection($results);
    }
}
