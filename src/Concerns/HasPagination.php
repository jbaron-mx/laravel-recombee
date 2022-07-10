<?php

namespace Baron\Recombee\Concerns;

use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;

trait HasPagination
{
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
