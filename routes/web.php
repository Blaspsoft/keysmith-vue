<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APITokens\TokenController;

Route::get('/api-tokens', [TokenController::class, 'index'])->name('api-tokens.index');
Route::post('/api-tokens', [TokenController::class, 'store'])->name('api-tokens.store');
Route::put('/api-tokens/{token}', [TokenController::class, 'update'])->name('api-tokens.update');
Route::delete('/api-tokens/{token}', [TokenController::class, 'destroy'])->name('api-tokens.destroy');
