<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminApiController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\GlobalApiController;
use App\Http\Controllers\ProviderApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 Route::get('/', function () {
    return view('welcome');
});

/*

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
 */

 Route::get('/test-update-files', [TestController::class, 'testUpdateFiles'])->name('test.update-files');
Route::post('/test-update-files-store', [TestController::class, 'testUpdateFilesStore'])->name('test.update-files-store');

/*require __DIR__.'/auth.php'; */


/*  GLOBAL ROUTES */
Route::post('/login', [GlobalApiController::class, 'loginUser'])->name('api.loginUser'); 
Route::post('/reset-password', [GlobalApiController::class, 'resetPassword'])->name('api.resetPassword');

/* ADMIN ROUTES */
Route::get('/allOrders/{token}', [AdminApiController::class, 'allOrders'])->name('api.allOrders');
Route::get('/allOrdersByCompany/{token}', [AdminApiController::class, 'allOrdersByCompany'])->name('api.allOrdersByCompany');
Route::post('/updateOrderStatus', [AdminApiController::class, 'updateOrderStatus'])->name('api.updateOrderStatus');
Route::get('/allUsers/{token}', [AdminApiController::class, 'allUsers'])->name('api.allUsers');
Route::get('/requiredUserData', [AdminApiController::class, 'requiredUserData'])->name('api.requiredUserData');
Route::get('/editUser/{user_id}', [AdminApiController::class, 'editUser'])->name('api.editUser');
Route::post('/updateUser', [AdminApiController::class, 'updateUser'])->name('api.updateUser');
Route::post('/storeUser', [AdminApiController::class, 'storeUser'])->name('api.storeUser');
Route::post('/deleteUser', [AdminApiController::class, 'deleteUser'])->name('api.deleteUser');
Route::get('/general', [AdminApiController::class, 'general'])->name('api.general');

/* Route::post('/updateXML', [AdminApiController::class, 'updateXML'])->name('api.updateXML');
Route::post('/updatePDF', [AdminApiController::class, 'updatePDF'])->name('api.updatePDF'); */
Route::get('/generalInitialInvoinces', [AdminApiController::class, 'generalInitialInvoinces'])->name('api.generalInitialInvoinces');
Route::post('/invoicesByDate', [AdminApiController::class, 'invoicesByDate'])->name('api.invoicesByDate');

/* PROVIDER ROUTES */
Route::get('/providerOrders/{token}', [ProviderApiController::class, 'providerOrders'])->name('api.providerOrders');
Route::post('/updateFiles', [ProviderApiController::class, 'updateFiles'])->name('api.updateFiles');

/* FACTURAS */
Route::post('/blacklist', [BillController::class, 'blackList'])->name('bill.blackList');


/* TEST */
Route::post('/testOrders', [TestController::class, 'testOrders'])->name('api.testOrders');
