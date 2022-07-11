<?php

namespace Baron\Recombee\Tests\Database\Factories;

use Baron\Recombee\Tests\Fixtures\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'price' => $this->faker->randomNumber(4),
            'active' => true,
        ];
    }
}
