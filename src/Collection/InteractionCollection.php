<?php

declare(strict_types=1);

namespace Baron\Recombee\Collection;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InteractionCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->all();
    }
}
