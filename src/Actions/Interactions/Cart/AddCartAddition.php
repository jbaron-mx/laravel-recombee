<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Interactions\Cart;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\AddCartAddition as ApiRequest;

class AddCartAddition extends Action
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
