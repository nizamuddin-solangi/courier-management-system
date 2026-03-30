<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AdminController::class, 'login']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/couriers', [AdminController::class, 'couriers']);
Route::get('/admin/customers', [AdminController::class, 'customers']);
Route::get('/admin/reports', [AdminController::class, 'reports']);
Route::get('/admin/agents', [AdminController::class, 'agents']);
Route::get('/admin/sms', [AdminController::class, 'sms']);
Route::get('/admin/status', [AdminController::class, 'status']);
Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
Route::post('/admin/edit/{id}',[AdminController::class,'edit_admin']);
Route::post('/admin/update/{id}',[AdminController::class,'update_admin']);