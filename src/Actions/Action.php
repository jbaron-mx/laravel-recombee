<?php

namespace Baron\Recombee\Actions;

use Baron\Recombee\Builder;
use Baron\Recombee\Contracts\Executable;

abstract class Action implements Executable
{
    protected $apiRequest;
    protected array $defaultOptions;

    public function __construct(protected Builder $builder)
    {
        $this->builder = $builder;
        $this->setUp();
    }

    protected function setUp(): void
    {
    }
}
