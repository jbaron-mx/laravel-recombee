<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\Batch;

abstract class CreateAndDeleteProperties extends Action
{
    public function execute()
    {
        return $this->map($this->query());
    }

    protected function buildApiRequest()
    {
        $props = collect($this->builder->param('properties'))
            ->mapWithKeys(
                fn ($value, $key) => is_int($key)
                    ? [$value => 'string']
                    : [$key => $value]
            );

        $reqs = $this->generateBatch($props);

        return new Batch($reqs);
    }

    protected function map($response)
    {
        return collect($response)->reduce(function ($carry, $call) {
            $carry ??= ['success' => true, 'errors' => []];

            if ($error = Arr::get($call, 'json.error')) {
                $carry['errors'][] = $error;
            }

            return $carry;
        });
    }

    abstract protected function generateBatch(Collection $properties);
}
