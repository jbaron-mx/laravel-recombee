<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions;

use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;

abstract class ListingAndPaginate extends Action
{
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

    protected function paginate()
    {
        return Container::getInstance()->makeWith(Paginator::class, [
            'items' => $this->query(),
            'perPage' => $this->builder->option('count'),
            'currentPage' => $this->builder->param('page'),
            'options' => [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $this->builder->param('pageName'),
            ],
        ]);
    }
}
