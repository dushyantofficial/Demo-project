<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Post Api*/

Route::post('customer_login', [\App\Http\Controllers\API\UserAPIController::class, 'login'])->name('customer-login');
Route::post('add_customer', [\App\Http\Controllers\API\CustomerAPIController::class, 'add_customer'])->name('add-customer');
Route::post('add_user', [\App\Http\Controllers\API\UserAPIController::class, 'add_user'])->name('add-user');
Route::post('add_item_name', [\App\Http\Controllers\API\Item_NameAPIController::class, 'add_item'])->name('add-item-name');
Route::post('add_item_sales', [\App\Http\Controllers\API\Item_SalesAPIController::class, 'add_item_sales'])->name('add-item-sales');
Route::post('add_item_purchase', [\App\Http\Controllers\API\Item_PurchaseAPIController::class, 'add_item_purchase'])->name('add-item-purchase');
Route::post('user_logout', [\App\Http\Controllers\API\UserAPIController::class, 'user_logout'])->name('user-logout');

/*Get Api && Searching Filter*/
Route::get('get_user_list', [\App\Http\Controllers\API\UserAPIController::class, 'user_list'])->name('get-user-list');
Route::get('get_customer_list', [\App\Http\Controllers\API\CustomerAPIController::class, 'customer_list'])->name('get-customer-list');
Route::get('get_item_name_list', [\App\Http\Controllers\API\Item_NameAPIController::class, 'item_name_list'])->name('get-item-name-list');
Route::get('get_item_sales_list', [\App\Http\Controllers\API\Item_SalesAPIController::class, 'item_sales_list'])->name('get-item-sales-list');
Route::get('get_item_purchase_list', [\App\Http\Controllers\API\Item_PurchaseAPIController::class, 'item_purchase_list'])->name('get-item-purchase-list');

/*Get Api*/
Route::get('get_customer', [\App\Http\Controllers\API\UserAPIController::class, 'customer'])->name('get-customer');
Route::get('get_item_name', [\App\Http\Controllers\API\Item_NameAPIController::class, 'item_name'])->name('get-item-name');
Route::get('get_item_sales', [\App\Http\Controllers\API\Item_SalesAPIController::class, 'item_sales'])->name('get-item-sales');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
