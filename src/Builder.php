<?php

declare(strict_types=1);

namespace Baron\Recombee;

use Baron\Recombee\Support\Entity;
use Illuminate\Database\Eloquent\Model;

class Builder
{
    protected Entity $initiator;
    protected string $action;

    /**
     * Common Properties
     */
    public $cascadeCreate = true;

    /**
     * Recommendation Properties
     */
    public string|null $targetUserId = null;
    public $booster;
    public $filter;
    public $logic;
    public $scenario;
    public int $limit = 25;

    /**
     * Interaction Properties
     */
    public $timestamp;
    public $rating;

    public function __construct(
        protected Engine $engine
    ) {
    }

    public function engine(): Engine
    {
        return $this->engine;
    }

    public function for(Model|string $initiator): self
    {
        $this->initiator = new Entity($initiator);

        return $this;
    }

    public function seenBy(Model|string $targetUser): self
    {
        $this->targetUserId = (new Entity($targetUser))->getId();

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function recommendItems(): self
    {
        $this->action = 'recommendItemsTo' . $this->initiator->getEntityKeyName();

        return $this;
    }

    public function get()
    {
        return $this->performAction();
    }

    public function reset()
    {
        return $this->engine()->reset();
    }

    public function getInitiator(): Entity
    {
        return $this->initiator;
    }

    public function prepareOptions(): array
    {
        return collect([
            'scenario' => $this->scenario,
            'filter' => $this->filter,
            'logic' => $this->logic,
            'booster' => $this->booster,
            'timestamp' => $this->timestamp,
            'cascadeCreate' => $this->cascadeCreate,
        ])->filter()->all();
    }

    protected function performAction()
    {
        return $this->engine()->{$this->action}($this);
    }
}
