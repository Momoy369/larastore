<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\DashboardController;
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

// Group routes width prefix "admin"
Route::prefix('admin')->group(function () {

    // Group route with middeware "auth"
    Route::group(['middleware' => 'auth'], function () {
        // Route dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    });

    Route::resource('/category', CategoryController::class, ['as' => 'admin']);

    // Route product
    Route::resource('/product', ProductController::class, ['as' => 'admin']);

    // Route Order
    Route::resource('/order', OrderController::class, ['except'
        => ['create', 'store', 'edit', 'update', 'destroy'], 'as'
        => 'admin']);

    // Route Customer
    Route::get('/customer', [CustomerController::class, 'index'])
        ->name('admin.customer.index');
    
    // Route Sliders
    Route::resource('/slider', SliderController::class, [
        'except' =>
        ['show', 'create', 'edit', 'update'], 'as' => 'admin'
    ]);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('admin.profile.index');

    // Users

    Route::resource('/user', UserController::class, ['except' => ['show'], 'as' => 'admin']);

});
