<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\AddUserProperty as ApiRequest;

class AddUserProperty
{
    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->builder->engine()->client()->send(new ApiRequest(
            $this->builder->param('propertyName'),
            $this->builder->param('type')
        )) === 'ok' ? true : false;
    }
}
