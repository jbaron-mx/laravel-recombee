<?php

namespace Baron\Recombee\Actions\Miscellaneous;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\ResetDatabase as ApiRequest;

class ResetDatabase
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
        return $this->builder->engine()->client()->send(new ApiRequest());
    }
}
