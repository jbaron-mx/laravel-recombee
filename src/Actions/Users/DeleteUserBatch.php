<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\CreateAndDeleteEntities;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\DeleteUser as ApiRequest;

class DeleteUserBatch extends CreateAndDeleteEntities
{
    protected function generateBatch(Collection $entities)
    {
        return $entities->map(
            fn ($values) => new ApiRequest($values[$this->builder->getInitiator()->getKeyName()])
        )->all();
    }
}
