<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\TokenController;

Route::get('/settings/api-tokens', [TokenController::class, 'index'])->name('settings.api-tokens.index');
Route::post('/settings/api-tokens', [TokenController::class, 'store'])->name('settings.api-tokens.store');
Route::put('/settings/api-tokens/{token}', [TokenController::class, 'update'])->name('settings.api-tokens.update');
Route::delete('/settings/api-tokens/{token}', [TokenController::class, 'destroy'])->name('settings.api-tokens.destroy');
