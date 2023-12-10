<?php


use Illuminate\Support\Facades\Route;


Route::prefix('sanctum')->as('sanctum.')->group(function() {
   Route::post('sign-up', [\App\Http\Controllers\API\AuthController::class, 'signup'])->name('signup');
   Route::post('authenticate', [\App\Http\Controllers\API\AuthController::class, 'authenticate'])->name('authenticate');

   Route::middleware(['auth:sanctum'])->group(function() {
       Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->name('logout');
   });
});
