<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\TokenController;

Route::get('/settings/api-tokens', [TokenController::class, 'index'])->name('api-tokens.index');
Route::post('/settings/api-tokens', [TokenController::class, 'store'])->name('api-tokens.store');
Route::put('/settings/api-tokens/{token}', [TokenController::class, 'update'])->name('api-tokens.update');
Route::delete('/settings/api-tokens/{token}', [TokenController::class, 'destroy'])->name('api-tokens.destroy');
