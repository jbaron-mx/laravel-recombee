<?php

declare(strict_types=1);

namespace Baron\Recombee\Support;

use Illuminate\Database\Eloquent\Model;

class Entity
{
    protected $id;
    protected $key;

    public function __construct(Model|string $entity)
    {
        if ($entity instanceof Model) {
            $this->id = (string) $entity->getAttribute($entity->getKeyName());
            $this->key = $entity->getKeyName();
        } else {
            $this->id = $entity;
            $this->key = 'id';
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getKeyName()
    {
        return $this->key;
    }
}
