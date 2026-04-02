<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login_submit', [AdminController::class, 'login_submit'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/couriers', [AdminController::class, 'couriers'])->name('admin.couriers');
    Route::get('/admin/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/admin/customer/edit/{id}', [AdminController::class, 'edit_customer'])->name('admin.customer.edit');
    Route::post('/admin/customer/update/{id}', [AdminController::class, 'update_customer'])->name('admin.customer.update');
    Route::get('/admin/customer/delete/{id}', [AdminController::class, 'delete_customer'])->name('admin.customer.delete');
    Route::get('/admin/reports', [AdminController::class, 'reports']);
    Route::get('/admin/reports/download', [AdminController::class, 'download_report'])->name('admin.reports.download');
    Route::get('/admin/agents', [AdminController::class, 'agents']);
    Route::get('/admin/sms', [AdminController::class, 'sms'])->name('admin.sms');
    Route::post('/admin/sms/send', [AdminController::class, 'send_sms'])->name('admin.sms.send');
    Route::get('/admin/status', [AdminController::class, 'status']);
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/edit/{id}',[AdminController::class,'edit_admin']);
    Route::post('/admin/update/{id}',[AdminController::class,'update_admin']);
    Route::get('/admin/add_new_courier', [AdminController::class, 'add_new_courier'])->name('admin.add_new_courier');
    Route::post('/admin/store_courier', [AdminController::class, 'store_courier'])->name('admin.store_courier');
    Route::get('/admin/couriers/print/{id}', [AdminController::class, 'print_shipment'])->name('admin.courier.print');
    Route::get('/admin/delete_courier/{id}', [AdminController::class, 'delete_courier'])->name('admin.delete_courier');
    Route::get('/admin/update_courier/{id}', [AdminController::class, 'update_courier'])->name('admin.update_courier');
    Route::post('/admin/execute_update_courier/{id}', [AdminController::class, 'execute_update_courier'])->name('admin.execute_update_courier');
    Route::get('/admin/add_new_agent', [AdminController::class, 'create_agent'])->name('admin.add_new_agent');
    Route::post('/admin/store_agent', [AdminController::class, 'store_agent'])->name('admin.store_agent');
    Route::get('/admin/show_agent', [AdminController::class, 'show_agent'])->name('admin.show_agent');
    Route::get('/admin/delete_agent/{id}', [AdminController::class, 'delete_agent'])->name('admin.delete_agent');
    Route::get('/admin/update_agent/{id}', [AdminController::class, 'update_agent'])->name('admin.update_agent');
    Route::post('/admin/execute_update_agent/{id}', [AdminController::class, 'execute_update_agent'])->name('admin.execute_update_agent');
});