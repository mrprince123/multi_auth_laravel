<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Employee 
Route::group(['middleware' => 'guest'], function(){
    Route::get('/employee/login', [LoginController::class, 'index'])->name('employee.login');
    Route::post('/employee/auth', [LoginController::class, 'authLogin'])->name('employee.authLogin');
    Route::get('/employee/register', [LoginController::class, 'register'])->name('employee.register');
    Route::post('/employee/register', [LoginController::class, 'processRegister'])->name('employee.authRegister');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/employee/dashboard', [LoginController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/employee/logout', [LoginController::class, 'logout'])->name('employee.logout');    
});

// Admin Route
Route::group(['middleware'=>'admin.guest'], function(){
    Route::get('/admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'authLogin'])->name('admin.authLogin');
});

Route::group(['middleware'=>'admin.auth'], function(){
    Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});


