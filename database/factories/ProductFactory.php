<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function Symfony\Component\Clock\now;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'=>fake()->text(),
            'image'=> fake()-> imageUrl(),
            'description'=> fake()->realText(2000),
            'price'=> fake()->randomFloat(2,10,60),
            'created_at'=> now(),
            'updated_at'=> now(),
            'created_by'=> 1,
            'updated_by'=> 1,
        ];
    }
}
