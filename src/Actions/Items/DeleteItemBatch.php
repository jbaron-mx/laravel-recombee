<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Actions\CreateAndDeleteEntities;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\DeleteItem as ApiRequest;

class DeleteItemBatch extends CreateAndDeleteEntities
{
    protected function generateBatch(Collection $entities)
    {
        return $entities->map(
            fn ($values) => new ApiRequest($values[$this->builder->getInitiator()->getKeyName()])
        )->all();
    }
}
