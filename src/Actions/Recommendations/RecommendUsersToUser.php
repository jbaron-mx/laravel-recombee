<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Recommendations;

use Baron\Recombee\Actions\ListRecommendations;
use Recombee\RecommApi\Requests\RecommendUsersToUser as ApiRequest;

class RecommendUsersToUser extends ListRecommendations
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
