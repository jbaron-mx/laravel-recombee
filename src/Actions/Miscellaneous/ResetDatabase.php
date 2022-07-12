<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Miscellaneous;

use Baron\Recombee\Actions\Action;
use Recombee\RecommApi\Requests\ResetDatabase as ApiRequest;

class ResetDatabase extends Action
{
    public function execute()
    {
        return $this->mapAsBoolean($this->query());
    }

    protected function buildApiRequest()
    {
        return new ApiRequest();
    }
}
