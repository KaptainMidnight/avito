<?php

use Illuminate\Support\Facades\Route;

Route::prefix('profile')->as('profile.')->middleware(['auth:sanctum'])->group(function() {
    Route::get('/', [\App\Http\Controllers\API\ProfileController::class, 'index'])->name('index');
});
