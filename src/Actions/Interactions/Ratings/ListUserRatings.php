<?php

namespace Baron\Recombee\Actions\Interactions\Ratings;

use Baron\Recombee\Builder;
use Baron\Recombee\Collection\InteractionCollection;
use Recombee\RecommApi\Requests\ListUserRatings as ApiRequest;

class ListUserRatings
{
    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->map(
            $this->builder->engine()->client()->send(new ApiRequest(
                $this->builder->getInitiator()->getId()
            ))
        );
    }

    public function map($results): InteractionCollection
    {
        return new InteractionCollection($results);
    }
}