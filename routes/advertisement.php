<?php

use App\Http\Controllers\API\AdvertisementController;
use App\Http\Middleware\IsOwnerAdvertisement;
use Illuminate\Support\Facades\Route;

Route::prefix('advertisement')->middleware(['auth:sanctum'])->as('advertisement.')->group(function () {
    Route::get('/', [AdvertisementController::class, 'index'])->name('index');
    Route::post('/', [AdvertisementController::class, 'store'])->name('store');
    Route::get('/{advertisement}', [AdvertisementController::class, 'show'])->name('show');

    Route::middleware([IsOwnerAdvertisement::class])->group(function() {
        Route::put('/{advertisement}', [AdvertisementController::class, 'update'])->name('update');
        Route::delete('/{advertisement}', [AdvertisementController::class, 'destroy'])->name('destroy');
    });
});
