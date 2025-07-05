<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/login', 'adminLogin')->name('admin.login');
    Route::get('/admin/dashboard', 'adminDashboard')->name('admin.dashboard');
    Route::get('admin/logout', 'adminLogout')->name('admin.logout'); 
    Route::post('/login', 'login')->name('admin.login.submit');
}); 

Route::resource('sales', SaleController::class);
Route::get('sales/trash', [SaleController::class, 'trash'])->name('sales.trash');
Route::post('sales/{id}/restore', [SaleController::class, 'restore'])->name('sales.restore');


