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
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect()->route('login');
});

//guest routes
Route::middleware('guest')->group(function () {
    Route::get('login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
    Route::get('register', [App\Http\Controllers\AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.post');
});

//authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::post('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
}); 


Route::resource('products', ProductController::class);

