<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $store = Store::factory()
            ->count(1)
            ->create()
            ->first();

        $users = User::factory()
            ->count(3)
            ->state(new Sequence(
                ['is_admin' => true, 'is_seller' => true, 'is_buyer' => true],
                ['is_admin' => false, 'is_seller' => true, 'is_buyer' => false],
                ['is_admin' => false, 'is_seller' => false, 'is_buyer' => true],
            ))
            ->for($store)
            ->create();

        $items = Item::factory()
            ->count(20)
            ->for($store)
            ->create();

        Transaction::factory()
            ->count(fake()->numberBetween(100, 1000))
            ->create();
    }
}
