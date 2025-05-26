<?php

namespace Database\Factories;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $counter = 0;
    public function definition(): array
    {
        $name = ['Batman','Superman','Flash','Spider-Man','Hulk','Wolverine'];
        return [
            'name' => $name[self::$counter],
            'slug' => 'character' . self::$counter,
            'description' => fake()->text(200),
            'image' => $name[self::$counter++].'.png',
            'first_appearance' => fake()->date(),
            'publisher_id' => Publisher::inRandomOrder()->first()->id ?? Publisher::factory(),
        ];
    }
}
