<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\SetItemValues as ApiRequest;

class AddItem extends Action
{
    protected array $defaultOptions = [
        'cascadeCreate' => true,
    ];

    public function execute()
    {
        return $this->mapAsBoolean($this->query());
    }

    protected function buildApiRequest()
    {
        return new ApiRequest(
            $this->builder->getInitiator()->getId(),
            $this->builder->getInitiator()->getValues(),
            $this->builder->prepareOptions($this->defaultOptions)
        );
    }
}
