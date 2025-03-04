<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
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
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $store = Auth::user()->store;
        $validatedData['store_id'] = $store->id; // Add the store_id to the validated data

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validatedData['image'] = $imageName;
        }

        $item = Item::create($validatedData);

        return response()->json($item, 201);
    }

    public function show(int $item_id): \Illuminate\Http\JsonResponse
    {
        $store = Auth::user()->store;
        $item = $store->items->find($item_id);
        return response()->json($item);
    }

    public function update(Request $request, Item $item): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $store = Auth::user()->store;
        $item = $store->items->find($item);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $validatedData['image'] = $imageName;
        }

        $item->update($validatedData);

        return response()->json($item, 200);
    }

    public function destroy(Item $item): \Illuminate\Http\JsonResponse
    {
        $store = Auth::user()->store;
        $item = $store->items->find($item);
        $item->delete();

        return response()->json(null, 204);
    }
}
