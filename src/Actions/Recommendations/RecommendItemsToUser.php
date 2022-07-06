<?php

namespace Baron\Recombee\Actions\Recommendations;

use Baron\Recombee\Builder;
use Illuminate\Support\Arr;
use Baron\Recombee\Collection\RecommendationCollection;
use Recombee\RecommApi\Requests\RecommendItemsToUser as ApiRequest;

class RecommendItemsToUser
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
                $this->builder->getInitiator()->getId(),
                $this->builder->limit(),
                $this->builder->prepareOptions($this->defaultOptions)
            ))
        );
    }

    public function map($results): RecommendationCollection
    {
        return (new RecommendationCollection(Arr::get($results, 'recomms')))
            ->additional(['meta' => Arr::except($results, 'recomms')]);
    }
}
