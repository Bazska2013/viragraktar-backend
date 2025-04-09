<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $labels = ['red', 'blue', 'green', 'yellow', 'purple', 'orange', 'pink', 'brown', 'gray', 'black', 'white', 'fall', 'spring', 'summer', 'winter', 'new', 'old', 'used', 'vintage', 'retro', 'modern', 'classic', 'trendy', 'stylish', 'elegant', 'casual', 'formal', 'business', 'sporty', 'athletic', 'outdoor', 'indoor'];
        $selectedLabels = fake()->randomElements($labels, fake()->numberBetween(1, 5));
        return [
            'name' => fake()->word(),
            'description' => '{"labels":' . json_encode($selectedLabels) . ',"connections":[]}',
            'price' => fake()->numberBetween(10, 99)*10,
            'stock' => fake()->numberBetween(1, 100),
        ];
    }
}
