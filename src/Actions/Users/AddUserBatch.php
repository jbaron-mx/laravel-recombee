<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\CreateAndDeleteEntities;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\SetUserValues as ApiRequest;

class AddUserBatch extends CreateAndDeleteEntities
{
    protected function generateBatch(Collection $entities)
    {
        return $entities->map(function ($userValues) {
            $userId = $userValues[$this->builder->getInitiator()->getKeyName()];
            Arr::forget($userValues, $this->builder->getInitiator()->getKeyName());

            return new ApiRequest(
                $userId,
                $userValues,
                $this->builder->prepareOptions($this->defaultOptions)
            );
        })->all();
    }
}
