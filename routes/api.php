<?php

use App\Http\Controllers\AdminApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* ADMIN ROUTES */
Route::get('/allOrders', [AdminApiController::class, 'allOrders'])->name('api.allOrders');


/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */