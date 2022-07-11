<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Actions\CreateAndDeleteEntities;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\SetItemValues as ApiRequest;

class AddItemBatch extends CreateAndDeleteEntities
{
    protected function generateBatch(Collection $entities)
    {
        return $entities->map(function ($itemValues) {
            $itemId = $itemValues[$this->builder->getInitiator()->getKeyName()];
            Arr::forget($itemValues, $this->builder->getInitiator()->getKeyName());

            return new ApiRequest(
                $itemId,
                $itemValues,
                $this->builder->prepareOptions($this->defaultOptions)
            );
        })->all();
    }
}
