<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'opening_hours' => ['required', 'string'],
            'calculation_enabled' => ['required', 'boolean'],
        ]);

        try {
            $store = Store::create($validatedData);

            $user = Auth::user();
            $user->store()->associate($store);
            $user->is_admin = true;
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
}
