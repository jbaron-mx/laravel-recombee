<?php

declare(strict_types=1);

namespace Baron\Recombee;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection as BaseCollection;

trait Recommendable
{
    public static function bootRecommendable()
    {
        static::addGlobalScope(new RecommendableScope());

        (new static())->registerRecommendableMacros();
    }

    public function registerRecommendableMacros()
    {
        $self = $this;

        BaseCollection::macro('recommendable', function () use ($self) {
            return $self->makeRecommendable($this);
        });

        BaseCollection::macro('unrecommendable', function () use ($self) {
            $self->removeFromRecommendable($this);
        });
    }

    public static function makeRecommendable($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        return $models->first()->recommendableEngine()->update($models);
    }

    public static function makeAllRecommendable()
    {
        $self = new static();

        return $self->newQuery()
            ->when(true, function ($query) use ($self) {
                $self->makeAllRecommendableUsing($query);
            })
            ->orderBy($self->getKeyName())
            ->recommendable();
    }

    public function recommendable()
    {
        $this->newCollection([$this])->recommendable();
    }

    public function toRecommendableArray(): array
    {
        return $this->toArray();
    }

    public function toRecommendableProperties(): array
    {
        return [];
    }

    protected function makeAllRecommendableUsing(Builder $query)
    {
        return $query;
    }

    protected function recommendableEngine(): Engine
    {
        return app()->make(Engine::class);
    }
}
