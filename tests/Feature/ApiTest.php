<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Store $store;

    protected function setUp(): void
    {
        parent::setUp();

        $this->store = Store::factory()->create();
        $this->user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
            'is_seller' => true,
            'is_buyer' => true,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);

        $this->user->store()->associate($this->store);
        $this->user->save();
    }

    /**
     * Test the /api/user endpoint.
     */
    public function test_get_user(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->get('/api/user');

        $response->assertStatus(200);
    }

    public function test_post_store(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->post('/api/store', [
            'name' => 'Test Store',
            'opening_hours' => '{"Mon":{"from":"00:00","to":"00:00","closed":false},"Tue":{"from":"00:00","to":"00:00","closed":false},"Wed":{"from":"00:00","to":"00:00","closed":false},"Thu":{"from":"00:00","to":"00:00","closed":false},"Fri":{"from":"00:00","to":"00:00","closed":false},"Sat":{"from":"00:00","to":"00:00","closed":false},"Sun":{"from":"00:00","to":"00:00","closed":false}}',
            'currency' => '{"sign":"Ft","before":false}'
        ]);

        $response->assertStatus(201);
    }

    public function test_post_item(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $selectedLabels = ['red', 'blue', 'green'];

        $response = $this->post('/api/item', [
            'name' => 'Test Item',
            'description' => '{"labels":' . json_encode($selectedLabels) . ',"connections":[]}',
            'price' => 100,
            'stock' => 10,
        ]);

        $response->assertStatus(201);
    }

    public function test_get_store(): void
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->get('/api/store');
        $response->assertStatus(200);
    }

    public function test_post_join(): void
    {
        $new_user = User::factory()->create();
        $this->actingAs($new_user, 'sanctum');
        $response = $this->post('/api/join', [
            'unique_id' => $this->store->unique_id,
        ]);
        $response->assertStatus(200);
    }

    public function test_put_store(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->put('/api/store', [
            'name' => 'Updated Store',
            'opening_hours' => '{"Mon":{"from":"00:00","to":"00:00","closed":false},"Tue":{"from":"00:00","to":"00:00","closed":false},"Wed":{"from":"00:00","to":"00:00","closed":false},"Thu":{"from":"00:00","to":"00:00","closed":false},"Fri":{"from":"00:00","to":"00:00","closed":false},"Sat":{"from":"00:00","to":"00:00","closed":false},"Sun":{"from":"00:00","to":"00:00","closed":false}}',
            'currency' => '{"sign":"$","before":true}'
        ]);

        $response->assertStatus(200);
    }

    public function test_get_store_id(): void
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->get('/api/store/id');
        $response->assertStatus(200);
    }

    public function test_get_store_users(): void
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->get('/api/store/users');
        $response->assertStatus(200);
    }

    public function test_post_store_users_remove(): void
    {
        $new_user = User::factory()->create();
        $new_user->store()->associate($this->store);
        $this->actingAs($this->user, 'sanctum');
        $response = $this->post('/api/store/users/remove/' . $new_user->id);
        $response->assertStatus(204);
    }

    public function test_get_items(): void
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->get('/api/items');
        $response->assertStatus(200);
    }

    public function test_get_item(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $item = Item::factory()->create([
            'store_id' => $this->store->id,
        ]);

        $response = $this->get('/api/item/' . $item->id);

        $response->assertStatus(200);
    }

    public function test_post_item_edit(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $item = Item::factory()->create([
            'store_id' => $this->store->id,
        ]);

        $response = $this->post('/api/item/edit/' . $item->id, [
            'name' => 'Updated Item',
            'description' => '{"labels":[],"connections":[]}',
            'price' => 200,
            'stock' => 20,
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_item(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $item = Item::factory()->create([
            'store_id' => $this->store->id,
        ]);

        $response = $this->delete('/api/item/' . $item->id);

        $response->assertStatus(204);
    }

    public function test_get_user_transactions(): void
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->get('/api/user/transactions');
        $response->assertStatus(200);
    }

    public function test_get_store_transactions(): void
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->get('/api/store/transactions');
        $response->assertStatus(200);
    }

    public function test_post_new_transaction(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $item = Item::factory()->create([
            'store_id' => $this->store->id,
        ]);

        $response = $this->post('/api/new/transaction', [
            'items' => [
                [
                    'id' => $item->id,
                    'amount' => 1,
                ],
            ],
            'total' => 100,
            'credit' => false,
        ]);

        $response->assertStatus(201);
    }

    public function test_get_transaction(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $item = Item::factory()->create([
            'store_id' => $this->store->id,
        ]);

        $transaction = $this->post('/api/new/transaction', [
            'items' => [
                [
                    'id' => $item->id,
                    'amount' => 1,
                ],
            ],
            'total' => 100,
            'credit' => false,
        ])->getData();

        $response = $this->get('/api/transaction/' . $transaction->id);

        $response->assertStatus(200);
    }

    public function test_get_profit_today(): void
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->get('/api/store/profit/today');
        $response->assertStatus(200);
    }

    public function test_post_register(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'example@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(204);
    }

    public function test_post_login(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'Test Device',
        ]);

        $response->assertStatus(200);
    }

    public function test_update_privileges(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->post('/api/update-privileges/' . $this->user->id, [
            'is_admin' => true,
            'is_seller' => false,
            'is_buyer' => true,
        ]);

        $response->assertStatus(204);
    }

    public function test_post_change_password(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->post('/api/change-password', [
            'old_password' => '12345678',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(200);
    }

    public function test_post_change_name(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->post('/api/change-name', [
            'name' => 'New Name',
        ]);

        $response->assertStatus(200);
    }

    public function test_get_transactions_date(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->get('/api/transactions/' . now()->format('Y-m-d'));

        $response->assertStatus(200);
    }

    public function test_get_transactions_range(): void
    {
        $this->actingAs($this->user, 'sanctum');

        $response = $this->get('/api/transactions/' . now()->format('Y-m-d') . '/' . now()->addDays(7)->format('Y-m-d'));

        $response->assertStatus(200);
    }
}
