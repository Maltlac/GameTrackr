<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->optional()->paragraph,
            'cover_url' => $this->faker->optional()->imageUrl(),
            'release_date' => $this->faker->optional()->date(),
            'percentage' => $this->faker->optional()->randomFloat(2, 0, 100),
        ];
    }
}
