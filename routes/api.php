<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->post('/new/store', 'App\Http\Controllers\StoreController@store')
    ->middleware('auth')
    ->name('new.store');

Route::middleware(['auth:sanctum'])->get('/store', 'App\Http\Controllers\StoreController@index')
    ->middleware('auth')
    ->name('store');

Route::middleware(['auth:sanctum'])->post('/join', 'App\Http\Controllers\StoreController@join')
    ->middleware('auth')
    ->name('join');

Route::middleware(['auth:sanctum'])->get('/store/id', 'App\Http\Controllers\StoreController@id')
    ->middleware('auth')
    ->name('store.id');

Route::get('/items', 'App\Http\Controllers\ItemController@index');
