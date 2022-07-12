<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\MergeUsers as ApiRequest;

class MergeUsers extends Action
{
    public function execute()
    {
        return $this->mapAsBoolean($this->query());
    }

    protected function buildApiRequest()
    {
        return new ApiRequest(
            $this->builder->getTarget()->getId(),
            $this->builder->getInitiator()->getId(),
            $this->builder->prepareOptions($this->defaultOptions)
        );
    }
}
