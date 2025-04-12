<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'opening_hours' => ['required', 'string'],
            'currency' => ['required', 'string'],
        ]);

        try {
            do {
                $uniqueId = strtoupper(Str::random(6));
            } while (Store::where('unique_id', $uniqueId)->exists());

            $validatedData['unique_id'] = $uniqueId;
            $validatedData['labels'] = json_encode(['red', 'blue', 'green', 'yellow', 'purple', 'orange', 'pink', 'brown', 'gray', 'black', 'white', 'fall', 'spring', 'summer', 'winter', 'new', 'old', 'used', 'vintage', 'retro', 'modern', 'classic', 'trendy', 'stylish', 'elegant', 'casual', 'formal', 'business', 'sporty', 'athletic', 'outdoor', 'indoor']);

            $store = Store::create($validatedData);

            $user = Auth::user();
            $user->store()->associate($store);
            $user->is_admin = true;
            $user->is_seller = true;
            $user->is_buyer = true;
            $user->save();

            return response()->json($store, 201);
        } catch (\Exception $e) {
            Log::error('Error creating store:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create store.'], 500);
        }
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $store = $user->store;

        return response()->json($store, 200);
    }

    public function join(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'unique_id' => ['required', 'string', 'max:6'],
        ]);

        $store = Store::where('unique_id', $validatedData['unique_id'])->first();

        if (!$store) {
            return response()->json(['error' => 'Store not found.'], 404);
        }

        $user = Auth::user();
        $user->store()->associate($store);
        $user->save();

        return response()->json($store, 200);
    }

    public function id(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $store = $user->store;

        return response()->json($store->unique_id, 200);
    }

    public function users(): \Illuminate\Http\JsonResponse
    {
        $store = Auth::user()->store;
        $users = $store->users;

        return response()->json($users, 200);
    }

    public function removeUser(User $user): \Illuminate\Http\JsonResponse
    {
        $store = Auth::user()->store;

        if ($user->store_id === $store->id) {
            $user->store_id = null;
            $user->is_admin = false;
            $user->is_seller = false;
            $user->is_buyer = false;
            $user->save();
        }

        return response()->json(null, 204);
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['string', 'max:255'],
            'opening_hours' => ['string'],
            'currency' => ['required', 'string'],
            'labels' => ['string'],
        ]);

        $store = Auth::user()->store;
        $store->update($validatedData);

        return response()->json($store, 200);
    }
}
