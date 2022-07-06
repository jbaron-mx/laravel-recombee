<?php

namespace Baron\Recombee;

use Recombee\RecommApi\Client;

class Engine
{
    public function __construct(
        protected Client $recombee
    ) {
    }

    public function client()
    {
        return $this->recombee;
    }
}
