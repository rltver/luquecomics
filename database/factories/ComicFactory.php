<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;
use phpDocumentor\Reflection\Types\Self_;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comic>
 */
class ComicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $counter = 1;
    public function definition(): array
    {
        return [
            'title' => fake()->words(6, true),
            'author' => fake()->name(),
            'artist' => fake()->name(),
            'description' => fake()->text(200),
            'price' => fake()->randomFloat(2,2, 100),
            'stock' => fake()->numberBetween(0, 100),
            'thumbnail_image' => 'comic'.Self::$counter++.'.webp',
            'type' => fake()->randomElement(['Hard cover', 'Trade paperback','Omnibus']),
            'pages' => fake()->numberBetween(25, 400),
            'weight' => fake()->numberBetween(0, 2),
            'slug' => fake()->slug(),
            'publisher_id' => Publisher::inRandomOrder()->first()->id ?? Publisher::factory()
        ];
    }
}
