<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\GetUserValues as ApiRequest;

class GetUserValues extends Action
{
    public function execute()
    {
        return $this->query();
    }

    protected function buildApiRequest()
    {
        return new ApiRequest(
            $this->builder->getInitiator()->getId()
        );
    }
}
