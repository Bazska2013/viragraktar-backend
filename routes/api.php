<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->post('/new/store', 'App\Http\Controllers\StoreController@store')
    ->middleware('auth')
    ->name('new.store');

Route::middleware(['auth:sanctum'])->post('/new/item', 'App\Http\Controllers\ItemController@store')
    ->middleware('auth')
    ->name('new.item');

Route::middleware(['auth:sanctum'])->get('/store', 'App\Http\Controllers\StoreController@index')
    ->middleware('auth')
    ->name('store');

Route::middleware(['auth:sanctum'])->post('/join', 'App\Http\Controllers\StoreController@join')
    ->middleware('auth')
    ->name('join');

Route::middleware(['auth:sanctum'])->get('/store/id', 'App\Http\Controllers\StoreController@id')
    ->middleware('auth')
    ->name('store.id');

Route::middleware(['auth:sanctum'])->get('/store/users', 'App\Http\Controllers\StoreController@users')
    ->middleware('auth')
    ->name('store.users');

Route::middleware(['auth:sanctum'])->post('/store/users/remove/{user}', 'App\Http\Controllers\StoreController@removeUser')
    ->middleware('auth')
    ->name('store.users.remove');

Route::middleware(['auth:sanctum'])->get('/items', 'App\Http\Controllers\ItemController@index')
    ->middleware('auth')
    ->name('items');

Route::middleware(['auth:sanctum'])->get('/item/{item}', 'App\Http\Controllers\ItemController@show')
    ->middleware('auth')
    ->name('item');

Route::middleware(['auth:sanctum'])->put('/item/{item}', 'App\Http\Controllers\ItemController@update')
    ->middleware('auth')
    ->name('item.update');

Route::middleware(['auth:sanctum'])->delete('/item/{item}', 'App\Http\Controllers\ItemController@destroy')
    ->middleware('auth')
    ->name('item.delete');

Route::middleware(['auth:sanctum'])->get('/user/transactions', 'App\Http\Controllers\TransactionController@user_index')
    ->middleware('auth')
    ->name('user.transactions');

Route::middleware(['auth:sanctum'])->get('/store/transactions', 'App\Http\Controllers\TransactionController@store_index')
    ->middleware('auth')
    ->name('store.transactions');

Route::middleware(['auth:sanctum'])->post('/new/transaction', 'App\Http\Controllers\TransactionController@store')
    ->middleware('auth')
    ->name('new.transaction');

Route::middleware(['auth:sanctum'])->get('/transaction/{transaction}', 'App\Http\Controllers\TransactionController@show')
    ->middleware('auth')
    ->name('transaction');
