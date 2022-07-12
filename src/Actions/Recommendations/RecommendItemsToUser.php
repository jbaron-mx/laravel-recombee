<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Recommendations;

use Baron\Recombee\Actions\ListRecommendations;
use Recombee\RecommApi\Requests\RecommendItemsToUser as ApiRequest;

class RecommendItemsToUser extends ListRecommendations
{
    protected function generateRequest()
    {
        return new ApiRequest(
            $this->builder->getInitiator()->getId(),
            $this->builder->param('count'),
            $this->builder->prepareOptions($this->defaultOptions)
        );
    }
}
