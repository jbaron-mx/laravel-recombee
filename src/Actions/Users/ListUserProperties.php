<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\Action;
use Baron\Recombee\Collection\PropertyCollection;
use Recombee\RecommApi\Requests\ListUserProperties as ApiRequest;

class ListUserProperties extends Action
{
    public function execute()
    {
        return new PropertyCollection($this->query());
    }

    public function buildApiRequest()
    {
        return new ApiRequest();
    }
}
