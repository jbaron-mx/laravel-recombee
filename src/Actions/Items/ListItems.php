<?php

namespace Baron\Recombee\Actions\Items;

use Baron\Recombee\Builder;
use Baron\Recombee\Collection\ItemCollection;
use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;
use Recombee\RecommApi\Requests\ListItems as ApiRequest;

class ListItems
{
    protected array $defaultOptions = [
        'returnProperties' => true,
    ];

    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
        $this->defaultOptions['count'] = $this->builder->option('count') | $this->builder->param('count');
    }

    public function execute()
    {
        if (is_null($this->builder->param('page'))) {
            return $this->all();
        }

        return $this->paginate();
    }

    protected function paginate()
    {
        return Container::getInstance()->makeWith(Paginator::class, [
            'items' => $this->rawRequest(),
            'perPage' => $this->builder->option('count'),
            'currentPage' => $this->builder->param('page'),
            'options' => [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ],
        ]);
    }

    protected function all()
    {
        return $this->map($this->rawRequest());
    }

    protected function rawRequest()
    {
        return $this->builder->engine()->client()->send(new ApiRequest(
            $this->builder->prepareOptions($this->defaultOptions)
        ));
    }

    protected function map($results): ItemCollection
    {
        return new ItemCollection($results);
    }
}
