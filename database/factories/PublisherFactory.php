<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publisher>
 */
class PublisherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static $counter = 0;
    public function definition(): array
    {
        $name = ['DC','Marvel'];
        return [
            'name' => $name[self::$counter],
            'description' => fake()->text(200),
            'logo' => $name[self::$counter].'.png',
            'creation_date' => fake()->date(),
            'slug'=> $name[self::$counter++]
        ];
    }
}
