<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesArchiveController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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


    Route::get('/home', [HomeController::class ,'index'])->middleware(['auth', 'verified'])->name('home');



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

//export excel

Route::get('invoices_export', [InvoicesController::class, 'export']);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
   
});

//invoices_reports 

Route::get('/invoices_report',[InvoicesReportController::class,'report_page'])->name('reports');
Route::post('/search_invoices',[InvoicesReportController::class,'searchReport'])->name('Search_report');

//report

Route::get('/cusromer',[CustomerController::class,'index'])->name('customer_report');
Route::post('/search_customer',[CustomerController::class, 'searchReport'])->name('Search_Customer');

//تحديد قراءه الاشعارات

Route::get('/markeAsRead',[InvoicesController::class , 'MarkAsRead'])->name('marke_as_read');
Route::get('/{page}',[AdminController::class , 'index']);

