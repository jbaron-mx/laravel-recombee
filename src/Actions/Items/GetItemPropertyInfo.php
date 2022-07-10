<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\GetItemPropertyInfo as ApiRequest;

class GetItemPropertyInfo extends Action
{
    public function execute()
    {
        return $this->query();
    }

    protected function buildApiRequest()
    {
        return new ApiRequest(
            array_key_first($this->builder->param('properties'))
        );
    }
}
