<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DownloadController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])
    ->name('products.show');


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showForm'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showForm'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'register']);

});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [LogoutController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/checkout/{product}', [PaymentController::class, 'checkout'])
        ->name('payment.checkout');

    Route::get('/payment/return', [PaymentController::class, 'returnFromChapa'])
        ->name('payment.return');

    Route::get('/my-orders', [OrderController::class, 'myOrders'])
        ->name('orders.my');

Route::get('/orders', [OrderController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('orders.index');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::get('/orders/{order}/success', [OrderController::class, 'success'])
        ->name('orders.success');

    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('orders.cancel');

    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');

    Route::get('/orders/{order}/download', [DownloadController::class, 'download'])
        ->name('orders.download');

});


/*
|--------------------------------------------------------------------------
| Chapa Webhook
|--------------------------------------------------------------------------
*/

Route::post('/payment/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Products
        Route::resource('products', AdminProductController::class);
        Route::post('products/{product}/toggle', [AdminProductController::class, 'toggle'])
            ->name('products.toggle');

        // Categories
        Route::resource('categories', AdminCategoryController::class);

        // Orders
        Route::get('orders', [AdminOrderController::class, 'index'])
            ->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])
            ->name('orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
        Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])
            ->name('orders.destroy');

        // Users
        Route::get('users', [AdminUserController::class, 'index'])
            ->name('users.index');
        Route::get('users/{user}', [AdminUserController::class, 'show'])
            ->name('users.show');
        Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('users.edit');
        Route::patch('users/{user}', [AdminUserController::class, 'update'])
            ->name('users.update');
        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');

    });