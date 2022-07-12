<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Interactions\Ratings;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\AddRating as ApiRequest;

class AddRating extends Action
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
            $this->builder->param('rating'),
            $this->builder->prepareOptions()
        );
    }
}
