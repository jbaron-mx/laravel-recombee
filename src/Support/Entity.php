<?php

declare(strict_types=1);

namespace Baron\Recombee\Support;

use Illuminate\Database\Eloquent\Model;

class Entity
{
    protected const USER = 'User';
    protected const ITEM = 'Item';

    protected string $id;
    protected string $key = 'id';
    protected string $type = self::USER;

    public function __construct(Model|string $entity)
    {
        $userClass = config('recombee.user');
        $itemClass = config('recombee.item');

        if ($entity instanceof Model) {
            $this->id = (string) $entity->getAttribute($entity->getKeyName());
            $this->key = $entity->getKeyName();
            $this->type = match (true) {
                $entity instanceof $userClass => self::USER,
                $entity instanceof $itemClass => self::ITEM,
            };
        } else {
            $this->id = $entity;
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

    public function getEntityKeyName()
    {
        return $this->type;
    }

    public function isUser()
    {
        return $this->type === self::USER;
    }

    public function isItem()
    {
        return $this->type === self::ITEM;
    }
}
