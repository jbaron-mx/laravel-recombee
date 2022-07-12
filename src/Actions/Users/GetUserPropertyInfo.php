<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\GetUserPropertyInfo as ApiRequest;

class GetUserPropertyInfo extends Action
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
