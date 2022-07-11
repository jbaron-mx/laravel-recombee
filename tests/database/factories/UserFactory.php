<?php

namespace Baron\Recombee\Tests\Database\Factories;

use Baron\Recombee\Tests\Fixtures\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'active' => true,
        ];
    }
}
