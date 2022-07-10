<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Actions\ListingAndPaginate;
use Baron\Recombee\Collection\UserCollection;
use Recombee\RecommApi\Requests\ListUsers as ApiRequest;

class ListUsers extends ListingAndPaginate
{
    protected $apiRequest = ApiRequest::class;
    protected $collection = UserCollection::class;
}
