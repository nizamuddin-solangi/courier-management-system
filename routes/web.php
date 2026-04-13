<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { 
    return redirect()->route('user.index');
});


use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;

Route::get('/agent/login', [AgentController::class, 'login'])->name('agent.login');
Route::post('/agent/login_submit', [AgentController::class, 'login_submit'])->name('agent.login.submit');
Route::get('/agent/logout', [AgentController::class, 'logout'])->name('agent.logout');

Route::middleware(['agent.auth'])->prefix('agent')->group(function () {
    Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
    Route::get('/new-courier', [AgentController::class, 'new_courier'])->name('agent.new_courier');
    Route::post('/store-courier', [AgentController::class, 'store_courier'])->name('agent.store_courier');
    Route::get('/couriers', [AgentController::class, 'view_couriers'])->name('agent.view_couriers');
    Route::get('/sms', [AgentController::class, 'sms'])->name('agent.sms');
    Route::post('/sms/send', [AgentController::class, 'send_sms'])->name('agent.sms.send');
    Route::get('/reports', [AgentController::class, 'reports'])->name('agent.reports');
    Route::get('/reports/download', [AgentController::class, 'download_report'])->name('agent.reports.download');
    Route::get('/profile', [AgentController::class, 'profile'])->name('agent.profile');
    Route::post('/profile/update', [AgentController::class, 'update_profile'])->name('agent.profile.update');
});

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login_submit', [AdminController::class, 'login_submit'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');


Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
Route::get('/user/track', [UserController::class,'track'])->name('user.track');

Route::middleware(['user.auth'])->group(function () {
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'update_profile'])->name('user.profile.update');
    Route::get('/user/notifications', [UserController::class, 'notifications'])->name('user.notifications');
    Route::post('/user/notifications/mark-read', [UserController::class, 'notifications_mark_read'])->name('user.notifications.mark_read');
    Route::get('/user/track/lookup', [UserController::class,'track_lookup'])->name('user.track.lookup');
    Route::get('/user/track/download', [UserController::class,'track_download'])->name('user.track.download');
});
Route::get('/user/login', [UserController::class,'login'])->name('user.login');
Route::get('/user/register', [UserController::class,'register'])->name('user.register');
Route::post('/user/login_submit', [UserController::class,'login_submit'])->name('user.login.submit');
Route::post('/user/register_submit', [UserController::class,'register_submit'])->name('user.register.submit');
Route::get('/user/logout', [UserController::class,'logout'])->name('user.logout');

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


