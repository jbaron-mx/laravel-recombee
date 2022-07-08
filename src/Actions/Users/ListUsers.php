<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Builder;
use Baron\Recombee\Collection\UserCollection;
use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;
use Recombee\RecommApi\Requests\ListUsers as ApiRequest;

class ListUsers
{
    protected array $defaultOptions = [
        'returnProperties' => true,
    ];

    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
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

    protected function map($results): UserCollection
    {
        return new UserCollection($results);
    }
}
