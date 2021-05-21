<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

Route::get('/laravel', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login_user'])->name('login.submit');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register_user'])->name('register.submit');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/calculate-tax', [DashboardController::class, 'calculate_tax'])->name('calculate-tax');
Route::post('/calculate-tax', [DashboardController::class, 'calculate_tax_submit'])->name('calculate-tax-submit');

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::post('/admin/params/add', [AdminController::class, 'add_parameters'])->name('admin_add_params');
Route::post('/admin/params/update', [AdminController::class, 'update_parameters'])->name('admin_update_params');
Route::post('/admin/param-options/add', [AdminController::class, 'add_parameter_option'])->name('admin_add_param_option');
Route::post('/admin/tax-slabs/add', [AdminController::class, 'add_tax_slabs'])->name('admin_add_tax_slabs');

Route::get('/', [HomeController::class, 'index'])->name('home');