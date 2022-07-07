<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\DeleteUser as ApiRequest;

class DeleteUser
{
    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->builder->engine()->client()->send(new ApiRequest(
            $this->builder->getInitiator()->getId()
        )) === 'ok' ? true : false;
    }
}
