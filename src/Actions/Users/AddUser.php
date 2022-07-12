<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\SetUserValues as ApiRequest;

class AddUser extends Action
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
