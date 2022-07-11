<?php

namespace Baron\Recombee\Actions\Recommendations;

use Baron\Recombee\Actions\ListRecommendations;
use Recombee\RecommApi\Requests\RecommendUsersToItem as ApiRequest;

class RecommendUsersToItem extends ListRecommendations
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