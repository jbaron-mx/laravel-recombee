<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Actions\ListingAndPaginate;
use Baron\Recombee\Collection\ItemCollection;
use Recombee\RecommApi\Requests\ListItems as ApiRequest;

class ListItems extends ListingAndPaginate
{
    protected $apiRequest = ApiRequest::class;
    protected $collection = ItemCollection::class;
}
