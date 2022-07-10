<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions;

use Baron\Recombee\Concerns\HasPagination;

abstract class ListingAndPaginate extends Action
{
    use HasPagination;

    protected $apiRequest;
    protected $collection;

    protected function setUp(): void
    {
        $this->defaultOptions = [
            'returnProperties' => true,
            'count' => $this->builder->option('count') | $this->builder->param('count'),
        ];
    }

    public function execute()
    {
        if (is_null($this->builder->param('page'))) {
            return $this->all();
        }

        return $this->paginate();
    }

    protected function buildApiRequest()
    {
        return new ($this->apiRequest)(
            $this->builder->prepareOptions($this->defaultOptions)
        );
    }

    protected function all()
    {
        return new ($this->collection)($this->query());
    }
}
