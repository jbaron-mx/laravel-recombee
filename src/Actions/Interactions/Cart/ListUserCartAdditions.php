<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Interactions\Cart;

use Baron\Recombee\Actions\Action;
use Baron\Recombee\Collection\InteractionCollection;
use Recombee\RecommApi\Requests\ListUserCartAdditions as ApiRequest;

class ListUserCartAdditions extends Action
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
