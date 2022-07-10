<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions;

use Baron\Recombee\Collection\RecommendationCollection;
use Illuminate\Support\Arr;
use Recombee\RecommApi\Requests\RecommendNextItems;

abstract class ListRecommendations extends Action
{
    protected int $defaultCount = 25;
    protected array $defaultOptions = [
        'returnProperties' => true,
    ];

    public function execute()
    {
        return $this->map($this->query());
    }

    protected function buildApiRequest()
    {
        $this->builder->param('count', $this->builder->param('count') ?: $this->defaultCount);

        if (is_null($baseRecommendationId = $this->builder->param('baseRecommendationId'))) {
            return $this->generateRequest();
        }

        return new RecommendNextItems($baseRecommendationId, $this->builder->param('count'));
    }

    protected function map($results): RecommendationCollection
    {
        return (new RecommendationCollection(Arr::get($results, 'recomms')))
            ->additional(['meta' => Arr::except($results, 'recomms')]);
    }

    abstract protected function generateRequest();
}
