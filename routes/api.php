<?php

use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WalletController;
use Illuminate\Support\Facades\Route;

// User Routes
Route::post('/users', [UserController::class, 'create']);
Route::get('/users/{id}', [UserController::class, 'show']);

// Wallet Routes
Route::post('/wallets/{userId}/deposit', [WalletController::class, 'deposit']);
Route::post('/wallets/{userId}/withdraw', [WalletController::class, 'withdraw']);

// Transaction Routes
Route::post('/transactions/transfer', [TransactionController::class, 'transfer']);
Route::get('/transactions/{userId}', [TransactionController::class, 'getTransactions']);
