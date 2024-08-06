<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;

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

Route::get('/sales', [SaleController::class, 'index']);
Route::get('sales/data', [SaleController::class, 'getSalesData'])->name('sales.data');

Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
Route::post('/sales/save', [SaleController::class, 'store'])->name('sales.save');

Route::post('/sales/getInvoiceNumber', [SaleController::class, 'generateInvoiceNumber'])->name('getInvoiceNumber');

Route::get('/sales/{InvoiceNumber}/view', [SaleController::class, 'show'])->name('sales.view');
Route::get('/sales/{InvoiceNumber}/edit', [SaleController::class, 'edit'])->name('sales.edit');
Route::post('/sales/{InvoiceNumber}', [SaleController::class, 'update'])->name('sales.update');

Route::get('/export-csv', [SaleController::class, 'exportCsv'])->name('sales.export.csv');
Route::get('sales/export/pdf', [SaleController::class, 'exportPdf'])->name('sales.export.pdf');