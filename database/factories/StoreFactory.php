<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'opening_hours' => '{"Mon":{"from":"8:0","to":"17:0","closed":false},"Tue":{"from":"8:0","to":"17:0","closed":false},"Wed":{"from":"8:0","to":"17:0","closed":false},"Thu":{"from":"8:0","to":"17:0","closed":false},"Fri":{"from":"8:0","to":"17:0","closed":false},"Sat":{"from":"9:0","to":"16:0","closed":false},"Sun":{"from":"00:00","to":"00:00","closed":true}}',
            'calculation_enabled' => fake()->boolean(),
            'unique_id' => strtoupper(Str::random(6)),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
