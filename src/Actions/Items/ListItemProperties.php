<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Actions\Action;
use Baron\Recombee\Collection\PropertyCollection;
use Recombee\RecommApi\Requests\ListItemProperties as ApiRequest;

class ListItemProperties extends Action
{
    public function execute()
    {
        return $this->map($this->query());
    }

    protected function buildApiRequest()
    {
        return new ApiRequest();
    }

    protected function map($results): PropertyCollection
    {
        return new PropertyCollection($results);
    }
}
