<?php

namespace Baron\Recombee\Support;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InteractionCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->all();
    }
}
