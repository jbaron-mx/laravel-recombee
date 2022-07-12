<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\DeleteItem as ApiRequest;

class DeleteItem extends Action
{
    public function execute()
    {
        return $this->mapAsBoolean($this->query());
    }

    protected function buildApiRequest()
    {
        return new ApiRequest(
            $this->builder->getInitiator()->getId()
        );
    }
}
