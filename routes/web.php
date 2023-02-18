<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;

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
    return view('auth.login');
});

Route::post('/home', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('invoices', InvoicesController::class);

Route::resource('sections', SectionsController::class );

Route::resource('products',ProductsController::class);

Route::resource('attachments',InvoicesAttachmentsController::class);

Route::get('/section/{id}',[InvoicesController::class,'getproducts']);

Route::get('/invoicesDetails/{id}',[InvoicesDetailsController::class,'show'])->name('invoicesDetails');

//view attachment
Route::get('/View_file/{invoices_number}/{file_name}',[InvoicesDetailsController::class,'open_file']);

//download attachment
Route::get('/download/{invoices_number}/{file_name}',[InvoicesDetailsController::class,'get_file']);

//delet attachment
Route::post('/delete_file',[InvoicesDetailsController::class,'destroy'])->name('delete_file');

//edit invoices
Route::get('/edit_invoice/{id}',[InvoicesController::class,'edit'])->name('invoices.edit');

//edit statue
Route::get('/status_show/{id}',[InvoicesController::class,'status_show'])->name('status_show');


Route::post('/update_status/{id}',[InvoicesController::class,'update_status'])->name('update.status');

//الفواتير المدفوعه
Route::get('Invoice_Paid',[InvoicesController::class ,'InvoicesPaid'])->name('invoices.paid');
//الفواتير الغير المدفوعه
Route::get('Invoice_UnPaid',[InvoicesController::class ,'invoices_unpaid'])->name('invices.unpaid');
//الفواتير المدفوعه جزئيا
Route::get('Invoice_Partial',[InvoicesController::class ,'invoices_partial'])->name('invices.pratial');

//الارشيف
Route::resource('archive',InvoicesArchiveController::class);

//print invoices

Route::get('print_invoice/{id}',[InvoicesController::class ,'Print_Invoices']);


Route::get('/{page}',[AdminController::class , 'index']);

