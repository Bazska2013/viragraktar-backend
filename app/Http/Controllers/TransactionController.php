<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store_index() : \Illuminate\Http\JsonResponse
    {
        $store = Auth::user()->store;
        $transactions = $store->transactions;
        return response()->json($transactions);
    }

    public function user_index() : \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $transactions = $user->transactions;
        return response()->json($transactions);
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'items' => ['required', 'array'],
            'total' => ['required', 'numeric'],
            'credit' => ['required', 'boolean'],
        ]);

        $store = Auth::user()->store;
        $validatedData['store_id'] = $store->id;
        $validatedData['user_id'] = Auth::id();

        $transaction = Transaction::create($validatedData);

        foreach ($validatedData['items'] as $item) {
            $store->items->find($item['id'])->decrement('stock', $item['amount']);
        }

        return response()->json($transaction, 201);
    }

    public function show(int $transaction_id) : \Illuminate\Http\JsonResponse
    {
        $store = Auth::user()->store;
        $transaction = $store->transactions->find($transaction_id);
        return response()->json($transaction);
    }

    public function todayProfit() : \Illuminate\Http\JsonResponse
    {
        $store = Auth::user()->store;
        $transactions = $store->transactions;
        $today = now()->startOfDay();
        $profit = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->created_at >= $today) {
                $profit += $transaction->total;
            }
        }
        return response()->json($profit, 200);
    }
}
