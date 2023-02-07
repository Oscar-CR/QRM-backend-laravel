<?php

use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\GlobalApiController;
use App\Http\Controllers\ProviderApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*  GLOBAL ROUTES */
Route::post('/login', [GlobalApiController::class, 'login'])->name('api.login');


/* ADMIN ROUTES */
Route::get('/allOrders', [AdminApiController::class, 'allOrders'])->name('api.allOrders');
Route::get('/requiredUserData', [AdminApiController::class, 'requiredUserData'])->name('api.requiredUserData');
Route::get('/editUser/{user_id}', [AdminApiController::class, 'editUser'])->name('api.editUser');
Route::post('/updateUser', [AdminApiController::class, 'updateUser'])->name('api.updateUser');
Route::post('/deleteUser', [AdminApiController::class, 'deleteUser'])->name('api.deleteUser');

/* PROVIDER ROUTES */
Route::post('/providerOrders', [ProviderApiController::class, 'providerOrders'])->name('api.providerOrders');


/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */