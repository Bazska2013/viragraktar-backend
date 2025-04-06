<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $store_id = $this->faker->randomElement(Store::pluck('id')->toArray());
        $user_id = $this->faker->randomElement(User::pluck('id')->toArray());
        $store = Store::find($store_id);
        $user = User::find($user_id);
        $items = collect($this->faker->randomElements(Item::pluck('id')->toArray()));
        $total = 0;
        $itemsToUse = $items->map(function ($item) use (&$total) {
            $item = Item::find($item);
            $amount = $this->faker->numberBetween(1, 10);
            $total += $item->price * $amount;
            return [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'price' => $item->price,
                'stock' => $item->stock,
                'image' => $item->image,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'store_id' => $item->store_id,
                'amount' => $amount,
            ];
        });
        $created_at = $this->faker->dateTimeBetween(max($store->created_at, $user->created_at),'now');

        return [
            'items' => $itemsToUse,
            'total' => $total,
            'credit' => fake()->boolean(),
            'store_id' => $store_id,
            'user_id' => $user_id,
            'created_at' => $created_at,
        ];
    }
}
