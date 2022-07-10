<?php

declare(strict_types=1);

namespace Baron\Recombee\Actions;

use Baron\Recombee\Builder;

abstract class Action
{
    protected array $defaultOptions = [];

    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
        $this->setUp();
    }

    protected function setUp(): void
    {
    }

    protected function query(): mixed
    {
        return $this->builder->engine()->client()->send($this->buildApiRequest());
    }

    protected function mapAsBoolean($response): bool
    {
        return $response === 'ok' ? true : false;
    }

    abstract protected function execute();

    abstract protected function buildApiRequest();
}
