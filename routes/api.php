<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum')->middleware('auth');

Route::middleware(['auth:sanctum'])->post('/store', 'App\Http\Controllers\StoreController@store')
    ->middleware('auth')
    ->name('new.store');

Route::middleware(['auth:sanctum'])->post('/item', 'App\Http\Controllers\ItemController@store')
    ->middleware('auth')
    ->name('new.item');

Route::middleware(['auth:sanctum'])->get('/store', 'App\Http\Controllers\StoreController@index')
    ->middleware('auth')
    ->name('store');

Route::middleware(['auth:sanctum'])->post('/join', 'App\Http\Controllers\StoreController@join')
    ->middleware('auth')
    ->name('join');

Route::middleware(['auth:sanctum'])->put('/store', 'App\Http\Controllers\StoreController@update')
    ->middleware('auth')
    ->name('store.update');

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

Route::middleware(['auth:sanctum'])->post('/item/edit/{item}', 'App\Http\Controllers\ItemController@update')
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

Route::middleware(['auth:sanctum'])->get('/store/profit/today', 'App\Http\Controllers\TransactionController@todayProfit')
    ->middleware('auth')
    ->name('store.profit.today');

Route::post('/register', [UserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [AuthController::class, 'newPassword'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.store');

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth:sanctum'])->post('/update-privileges/{user}', [UserController::class, 'updatePrivileges'])
    ->middleware('auth')
    ->name('update.privileges');

Route::middleware(['auth:sanctum'])->post('/change-password', [UserController::class, 'changePassword'])
    ->middleware('auth')
    ->name('change.password');

Route::middleware(['auth:sanctum'])->post('/change-name', [UserController::class, 'changeName'])
    ->middleware('auth')
    ->name('change.name');

Route::middleware(['auth:sanctum'])->get('/transactions/{date}', 'App\Http\Controllers\TransactionController@showTransactionsInDay')
    ->middleware('auth')
    ->name('transactions.day');

Route::middleware(['auth:sanctum'])->get('/transactions/{start}-{end}', 'App\Http\Controllers\TransactionController@showTransactionsInRange')
    ->middleware('auth')
    ->name('transactions.range');
