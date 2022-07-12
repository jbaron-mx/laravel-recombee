<?php

declare(strict_types=1);

namespace Baron\Recombee;

use Baron\Recombee\Support\Entity;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Recombee\RecommApi\Client;

class Engine
{
    protected const RESERVED_PROPS = ['id', 'userId', 'itemId'];

    public function __construct(
        protected Client $recombee
    ) {
    }

    public function client()
    {
        return $this->recombee;
    }

    public function update(Collection $models)
    {
        if ($models->isEmpty()) {
            return null;
        }

        $entityType = (new Entity($models->first()))->getType();
        $recommendableData = $this->prepareRecommendableData($models);
        $recommendableProperties = $this->prepareRecommendableProperties($models, $recommendableData->first());

        if ($recommendableProperties->isNotEmpty()) {
            $response['properties'] = app()->make(Builder::class)
                ->$entityType()
                ->properties($recommendableProperties->all())
                ->save();
        }

        if ($recommendableData->isNotEmpty()) {
            $response[Str::plural($entityType)] = app()->make(Builder::class)
                ->$entityType()
                ->batch($recommendableData->all())
                ->save();
        }

        return $response ?? null;
    }

    public function delete(Collection $models)
    {
        if ($models->isEmpty()) {
            return null;
        }

        $entityType = (new Entity($models->first()))->getType();

        return app()->make(Builder::class)
            ->$entityType()
            ->batch($models->all())
            ->delete();
    }

    protected function prepareRecommendableData(Collection $models): Collection
    {
        return $models->map(function ($model) {
            return empty($recommendableData = $model->toRecommendableArray())
                ? null
                : $recommendableData;
        })->filter()->values();
    }

    protected function prepareRecommendableProperties(Collection $models, array $values)
    {
        $inferedProperties = collect($values)->flatMap(fn ($value, $key) => [$key => 'string']);

        return $this->removeReservedProperties(
            empty($recommendableProperties = $models->first()->toRecommendableProperties())
                ? $inferedProperties
                : $inferedProperties->merge($recommendableProperties)
        );
    }

    protected function removeReservedProperties(Collection $properties): Collection
    {
        return $properties->reject(fn ($value, $key) => in_array($key, self::RESERVED_PROPS));
    }
}
