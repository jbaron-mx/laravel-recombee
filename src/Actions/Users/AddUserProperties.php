<?php

namespace Baron\Recombee\Actions\Users;

use Baron\Recombee\Builder;
use Illuminate\Support\Arr;
use Recombee\RecommApi\Requests\AddUserProperty as ApiRequest;
use Recombee\RecommApi\Requests\Batch;

class AddUserProperties
{
    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
    }

    public function execute()
    {
        $props = collect($this->builder->param('properties'))
            ->mapWithKeys(
                fn ($value, $key) => is_int($key)
                    ? [$value => 'string']
                    : [$key => $value]
            );

        $reqs = $props->map(fn ($type, $name) => new ApiRequest($name, $type))->all();

        return $this->map($this->builder->engine()->client()->send(new Batch($reqs)));
    }

    public function map($response)
    {
        return collect($response)->reduce(function ($carry, $call) {
            $carry ??= ['success' => true, 'errors' => []];

            if ($error = Arr::get($call, 'json.error')) {
                $carry['errors'][] = $error;
            }

            return $carry;
        });
    }
}
