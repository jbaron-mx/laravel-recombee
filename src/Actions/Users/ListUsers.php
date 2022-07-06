<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Builder;
use Baron\Recombee\Collection\UserCollection;
use Recombee\RecommApi\Requests\ListUsers as ApiRequest;

class ListUsers
{
    protected array $defaultOptions = [
        'returnProperties' => true
    ];

    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->map(
            $this->builder->engine()->client()->send(new ApiRequest(
                $this->builder->prepareOptions($this->defaultOptions)
            ))
        );
    }

    public function map($results): UserCollection
    {
        return new UserCollection($results);
    }
}
