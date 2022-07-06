<?php

namespace Baron\Recombee;

use Baron\Recombee\Collection\InteractionCollection;
use Baron\Recombee\Collection\RecommendationCollection;
use Illuminate\Support\Arr;
use Recombee\RecommApi\Client;
use Recombee\RecommApi\Requests\AddPurchase;
use Recombee\RecommApi\Requests\DeletePurchase;
use Recombee\RecommApi\Requests\ListItemPurchases;
use Recombee\RecommApi\Requests\ListUserPurchases;

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
