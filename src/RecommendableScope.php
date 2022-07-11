<?php

declare(strict_types=1);

namespace Baron\Recombee;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class RecommendableScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        //
    }

    public function extend(Builder $builder)
    {
        $builder->macro('recommendable', function (Builder $builder) {
            return $builder->get()->recommendable();
            // event(new ModelsImported($models));
        });
    }
}
