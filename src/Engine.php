<?php

namespace Baron\Recombee;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Client;
use Baron\Recombee\Support\RecommendationCollection;
use Illuminate\Support\Arr;
use Recombee\RecommApi\Requests\ResetDatabase;
use Recombee\RecommApi\Requests\RecommendItemsToUser;

class Engine
{
    public function __construct(
        protected Client $recombee
    ) {}

    public function reset()
    {
        return $this->recombee->send(new ResetDatabase());
    }

    public function recommendItemsToUser(Builder $builder)
    {
        return $this->map($builder, $this->recombee->send(new RecommendItemsToUser(
            $builder->getInitiator()->getId(), 
            $builder->limit, 
            $builder->prepareOptions()
        )));
    }

    protected function map(Builder $builder, array $results)
    {
        return (new RecommendationCollection(
            collect(Arr::get($results, 'recomms'))
                ->pluck($builder->getInitiator()->getKeyName())
                ->values()
        ))->additional(['meta' => Arr::except($results, 'recomms')]);
    }
}
