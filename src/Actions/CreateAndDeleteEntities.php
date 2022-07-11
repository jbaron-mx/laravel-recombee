<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Recombee\RecommApi\Requests\Batch;

abstract class CreateAndDeleteEntities extends Action
{
    protected array $defaultOptions = [
        'cascadeCreate' => true,
    ];

    public function execute()
    {
        return $this->map($this->query());
    }

    protected function buildApiRequest()
    {
        $entities = collect($this->builder->param('entities'));
        $reqs = $this->generateBatch($entities);

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

    abstract protected function generateBatch(Collection $entities);
}
