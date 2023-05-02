<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\BillController;
use Illuminate\Support\Facades\Route;

Route::post('/blacklist', [BillController::class, 'blackList'])->name('bill.blackList');
