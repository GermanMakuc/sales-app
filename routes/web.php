<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommerceController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DeviceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('api/commerce/list', [CommerceController::class, 'index'])->name('commerce.index');
Route::post('api/commerce/create', [CommerceController::class, 'store'])->name('commerce.create');
Route::post('api/commerce/update/{id}', [CommerceController::class, 'update'])->name('commerce.update');
Route::post('api/commerce/delete/{id}', [CommerceController::class, 'destroy'])->name('commerce.delete');

Route::get('api/device/list', [DeviceController::class, 'index'])->name('device.index');
Route::post('api/device/create', [DeviceController::class, 'store'])->name('device.create');
Route::post('api/device/update/{id}', [DeviceController::class, 'update'])->name('device.update');
Route::post('api/device/delete/{id}', [DeviceController::class, 'destroy'])->name('device.delete');

Route::post('api/sale/create', [SaleController::class, 'store'])->name('sale.create');
Route::post('api/sale/cancel', [SaleController::class, 'update'])->name('sale.update');

Route::post('api/search/searchByPayment', [SaleController::class, 'searchByPayment'])->name('sale.searchByPayment');
Route::post('api/search/searchByStatus', [SaleController::class, 'searchByStatus'])->name('sale.searchByStatus');
Route::post('api/search/searchByDates', [SaleController::class, 'searchByDates'])->name('sale.searchByDates');
