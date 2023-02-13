<?php

use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\GlobalApiController;
use App\Http\Controllers\ProviderApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*  GLOBAL ROUTES */
Route::post('/login', [GlobalApiController::class, 'login'])->name('api.login'); 
Route::post('/send-mail', [GlobalApiController::class, 'sendMail'])->name('api.send-mail');

/* ADMIN ROUTES */
Route::get('/allOrders/{token}', [AdminApiController::class, 'allOrders'])->name('api.allOrders');
Route::get('/allOrdersByCompany/{token}', [AdminApiController::class, 'allOrdersByCompany'])->name('api.allOrdersByCompany');
Route::get('/allUsers', [AdminApiController::class, 'allUsers'])->name('api.allUsers');
Route::get('/requiredUserData', [AdminApiController::class, 'requiredUserData'])->name('api.requiredUserData');
Route::get('/editUser/{user_id}', [AdminApiController::class, 'editUser'])->name('api.editUser');
Route::post('/updateUser', [AdminApiController::class, 'updateUser'])->name('api.updateUser');
Route::post('/deleteUser', [AdminApiController::class, 'deleteUser'])->name('api.deleteUser');
Route::get('/general', [AdminApiController::class, 'general'])->name('api.general');
Route::post('/updateXML', [AdminApiController::class, 'updateXML'])->name('api.updateXML');
Route::post('/updatePDF', [AdminApiController::class, 'updatePDF'])->name('api.updatePDF');
Route::post('/generalInitialInvoinces', [AdminApiController::class, 'generalInitialInvoinces'])->name('api.generalInitialInvoinces');
Route::post('/invoicesByDate', [AdminApiController::class, 'invoicesByDate'])->name('api.invoicesByDate');


/* PROVIDER ROUTES */
Route::get('/providerOrders/{token}', [ProviderApiController::class, 'providerOrders'])->name('api.providerOrders');


/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */