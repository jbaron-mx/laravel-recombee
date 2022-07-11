<?php

declare(strict_types=1);

namespace Baron\Recombee;

use Baron\Recombee\Builder as RecombeeBuilder;
use Baron\Recombee\Support\Entity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Collection as BaseCollection;

trait Recommendable
{
    public static function bootRecommendable()
    {
        (new static())->registerRecommendableMacros();
    }

    public function registerRecommendableMacros()
    {
        $self = $this;

        BaseCollection::macro('recommendable', function () use ($self) {
            return $self->makeRecommendable($this);
        });

        BaseCollection::macro('unrecommendable', function () use ($self) {
            return $self->removeFromRecommendable($this);
        });
    }

    public static function makeRecommendable(Collection $models): array|null
    {
        if ($models->isEmpty()) {
            return null;
        }

        return $models->first()->recommendableBuilder()->engine()->update($models);
    }

    public static function removeFromRecommendable(Collection $models): array|null
    {
        if ($models->isEmpty()) {
            return null;
        }

        return $models->first()->recommendableBuilder()->engine()->delete($models);
    }

    public static function makeAllRecommendable(): array|null
    {
        $self = new static();

        return $self->newQuery()
            ->when(true, function ($query) use ($self) {
                $self->makeAllRecommendableUsing($query);
            })
            ->orderBy($self->getKeyName())
            ->get()
            ->recommendable();
    }

    public function recommendable(): array|null
    {
        return $this->newCollection([$this])->recommendable();
    }

    public function unrecommendable(): array|null
    {
        return $this->newCollection([$this])->unrecommendable();
    }

    public function toRecommendableArray(): array
    {
        return $this->toArray();
    }

    public function toRecommendableProperties(): array
    {
        return [];
    }

    public function recommendItems(string $baseRecommendationId = null): RecombeeBuilder
    {
        return $this->recommendableBuilder()
            ->{$this->recommendableType()}($this)
            ->recommendItems($baseRecommendationId);
    }

    public function recommendUsers(string $baseRecommendationId = null): RecombeeBuilder
    {
        return $this->recommendableBuilder()
            ->{$this->recommendableType()}($this)
            ->recommendUsers($baseRecommendationId);
    }

    protected function makeAllRecommendableUsing(Builder $query): Builder
    {
        return $query;
    }

    protected function recommendableType(): string
    {
        return (new Entity($this))->getType();
    }

    protected function recommendableBuilder(): RecombeeBuilder
    {
        return app()->make(RecombeeBuilder::class);
    }
}
