<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Builder;
use Recombee\RecommApi\Requests\SetItemValues as ApiRequest;

class AddItem
{
    protected array $defaultOptions = [
        'cascadeCreate' => true,
    ];

    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        return $this->builder->engine()->client()->send(new ApiRequest(
            $this->builder->getInitiator()->getId(),
            $this->builder->getInitiator()->getValues(),
            $this->builder->prepareOptions($this->defaultOptions)
        )) === 'ok' ? true : false;
    }
}
