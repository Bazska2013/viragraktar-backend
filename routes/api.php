<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->post('/new/store', 'App\Http\Controllers\StoreController@store')
    ->middleware('auth')
    ->name('new.store');

Route::get('/items', 'App\Http\Controllers\ItemController@index');
