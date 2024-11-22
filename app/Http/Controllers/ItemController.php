<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $store = Auth::user()->store;
        $items = $store->items;
        return response()->json($items);
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
//            'image' => ['required', 'string'],
        ]);

        $store = Auth::user()->store;
        $validatedData['store_id'] = $store->id; // Add the store_id to the validated data

        $item = Item::create($validatedData);

        return response()->json($item, 201);
    }
}
