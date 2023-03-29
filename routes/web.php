<?php

use Illuminate\Support\Facades\Route;

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

Route::get('clear_cache', function () {
    \Artisan::call('optimize:clear');
    return redirect()->route('home')->with("success", "Cache is cleared");
});


Auth::routes();


Route::group(['middleware' => ['auth', 'check_lang']], function () {

    /* Resource Route */
    Route::resource('user', App\Http\Controllers\admin\UserController::class);
    Route::resource('customer', App\Http\Controllers\admin\CustomerController::class);
    Route::resource('item_name', App\Http\Controllers\admin\ItemNameController::class);
    Route::resource('item_sales', App\Http\Controllers\admin\ItemSalesController::class);
    Route::resource('item_purchase', App\Http\Controllers\admin\ItemPurchaseController::class);


    /*Single Post Route*/
    Route::post('/profile_update', [App\Http\Controllers\admin\UserController::class, 'profile_update'])->name('profile-update');
    Route::post('/bank_update', [App\Http\Controllers\admin\CustomerController::class, 'bank_update'])->name('bank-update');
    Route::post('/change_password', [App\Http\Controllers\admin\UserController::class, 'change_password'])->name('change-password');
    Route::post('/import', [App\Http\Controllers\admin\CustomerController::class, 'import'])->name('import');

    /*Single Get Route*/
    Route::get('/profile', [App\Http\Controllers\admin\UserController::class, 'profile'])->name('profile');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\admin\UserController::class, 'profile'])->name('profile');
    Route::get('/english', [App\Http\Controllers\admin\UserController::class, 'english'])->name('english');
    Route::get('/gujarati', [App\Http\Controllers\admin\UserController::class, 'gujarati'])->name('gujarati');
    Route::get('get-quantity', [App\Http\Controllers\admin\ItemSalesController::class, 'getQuantity'])->name('get_quantity');
    Route::get('get_payment', [App\Http\Controllers\admin\ItemSalesController::class, 'getPayment'])->name('get_payment');

    /*Single Report Filter Route*/
    Route::get('/customer_report', [App\Http\Controllers\admin\ReportController::class, 'customer_report_show'])->name('customer-report-show');
    Route::get('customer_report_export', [App\Http\Controllers\admin\ReportController::class, 'customer_report_export'])->name('customer_report_export');
    Route::get('/item_name_report', [App\Http\Controllers\admin\ReportController::class, 'item_name_report_show'])->name('item-name-report-show');
    Route::get('item_name_report_export', [App\Http\Controllers\admin\ReportController::class, 'item_name_report_export'])->name('item_name_report_export');
    Route::get('/item_sales_report', [App\Http\Controllers\admin\ReportController::class, 'item_sales_report_show'])->name('item-sales-report-show');
    Route::get('item_sales_report_export', [App\Http\Controllers\admin\ReportController::class, 'item_sales_report_export'])->name('item_sales_report_export');
    Route::get('/item_purchase_report', [App\Http\Controllers\admin\ReportController::class, 'item_purchase_report_show'])->name('item-purchase-report-show');
    Route::get('item_purchase_report_export', [App\Http\Controllers\admin\ReportController::class, 'item_purchase_report_export'])->name('item_purchase_report_export');

    /*Single Report Pdf Route*/
    Route::get('/customer_report_pdf', [App\Http\Controllers\admin\ReportController::class, 'customer_report_pdf'])->name('customer-report-pdf');
    Route::get('/customer_report_show_pdf', [App\Http\Controllers\admin\ReportController::class, 'customer_report_show_pdf'])->name('customer-report-show-pdf');
    Route::get('/item_name_report_pdf', [App\Http\Controllers\admin\ReportController::class, 'item_name_report_pdf'])->name('item-name-report-pdf');
    Route::get('/item_name_report_show_pdf', [App\Http\Controllers\admin\ReportController::class, 'item_name_report_show_pdf'])->name('item-name-report-show-pdf');
    Route::get('/item_sales_report_pdf', [App\Http\Controllers\admin\ReportController::class, 'item_sales_report_pdf'])->name('item-sales-report-pdf');
    Route::get('/item_sales_report_show_pdf', [App\Http\Controllers\admin\ReportController::class, 'item_sales_report_show_pdf'])->name('item-sales-report-show-pdf');
    Route::get('/item_purchase_report_pdf', [App\Http\Controllers\admin\ReportController::class, 'item_purchase_report_pdf'])->name('item-purchase-report-pdf');
    Route::get('/item_purchase_report_show_pdf', [App\Http\Controllers\admin\ReportController::class, 'item_purchase_report_show_pdf'])->name('item-purchase-report-show-pdf');

    //Payment Report Route

    Route::get('item_sales_report_export', [App\Http\Controllers\admin\ReportController::class, 'item_sales_report_export'])->name('item_sales_report_export');
    Route::get('item_name_report_export', [App\Http\Controllers\admin\ReportController::class, 'item_name_report_export'])->name('item_name_report_export');
    Route::get('customer_report_export', [App\Http\Controllers\admin\ReportController::class, 'customer_report_export'])->name('customer_report_export');
    Route::get('item_purchase_report_export', [App\Http\Controllers\admin\ReportController::class, 'item_purchase_report_export'])->name('item_purchase_report_export');

    Route::get('get-quantity', [App\Http\Controllers\admin\ItemSalesController::class, 'getQuantity'])->name('get_quantity');
    Route::get('edit_get_quantity', [App\Http\Controllers\admin\ItemSalesController::class, 'edit_get_quantity'])->name('edit_get_quantity');
    Route::get('edit_get_payment', [App\Http\Controllers\admin\ItemSalesController::class, 'edit_get_payment'])->name('edit_get_payment');
    Route::get('get_payment', [App\Http\Controllers\admin\ItemSalesController::class, 'getPayment'])->name('get_payment');
//get_item_price

    Route::get('get_item_price', [App\Http\Controllers\admin\ItemSalesController::class, 'get_item_price'])->name('get_item_price');
//Payment Report Route
    Route::get('payment_register_report', [App\Http\Controllers\admin\PaymentReportController::class, 'payment_register_report'])->name('payment-register-report');
    Route::get('payment_register_report_pdf', [App\Http\Controllers\admin\PaymentReportController::class, 'payment_register_report_pdf'])->name('payment-register-report-pdf');
    Route::get('payment_register_report_export', [App\Http\Controllers\admin\PaymentReportController::class, 'payment_register_report_export'])->name('payment-register-report-export');
    Route::get('payment_register_report_export_pdf', [App\Http\Controllers\admin\PaymentReportController::class, 'payment_register_report_export_pdf'])->name('payment-register-report-export-pdf');
    Route::get('payment_deduct_report', [App\Http\Controllers\admin\PaymentReportController::class, 'payment_deduct_report'])->name('payment-deduct-report');
    Route::get('payment_deduct_report_pdf', [App\Http\Controllers\admin\PaymentReportController::class, 'payment_deduct_report_pdf'])->name('payment-deduct-report-pdf');
    Route::get('payment_deduct_report_export', [App\Http\Controllers\admin\PaymentReportController::class, 'payment_deduct_report_export'])->name('payment-deduct-report-export');
    Route::get('payment_deduct_report_export_pdf', [App\Http\Controllers\admin\PaymentReportController::class, 'payment_deduct_report_export_pdf'])->name('payment-deduct-report-export-pdf');

});
