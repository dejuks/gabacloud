<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\BlogController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminBlogCategoryController;

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

// Public Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('blog.show');


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

    // Checkout
    Route::get('/checkout/{product}', [PaymentController::class, 'checkout'])
        ->name('payment.checkout');

    // Chapa Return
    Route::get('/payment/return', [PaymentController::class, 'returnFromChapa'])
        ->name('payment.return');

    // Customer Orders
    Route::get('/my-orders', [OrderController::class, 'myOrders'])
        ->name('orders.my');

    Route::get('/orders/{order}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::get('/orders/{order}/success', [OrderController::class, 'success'])
        ->name('orders.success');

    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('orders.cancel');

    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])
        ->name('orders.destroy');

    // Download
    Route::get('/orders/{order}/download', [DownloadController::class, 'download'])
        ->name('orders.download');

});


/*
|--------------------------------------------------------------------------
| Chapa Webhook (no auth needed)
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

        // Dashboard
        Route::get('/', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Products
        Route::resource('products', AdminProductController::class);
        Route::post('products/{product}/toggle', [AdminProductController::class, 'toggle'])
            ->name('products.toggle');

        // Product Categories
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

        // Blog Posts
// Blog Posts
// Public Blog
Route::get('/blog',         [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog}',  [BlogController::class, 'show'])->name('blog.show');
Route::get('blog',                [AdminBlogController::class, 'index'])->name('blog.index');
Route::get('blog/create',         [AdminBlogController::class, 'create'])->name('blog.create');
Route::post('blog',               [AdminBlogController::class, 'store'])->name('blog.store');
Route::get('blog/{blog}',         [AdminBlogController::class, 'show'])->name('blog.show');
Route::get('blog/{blog}/edit',    [AdminBlogController::class, 'edit'])->name('blog.edit');
Route::put('blog/{blog}',         [AdminBlogController::class, 'update'])->name('blog.update');
Route::delete('blog/{blog}',      [AdminBlogController::class, 'destroy'])->name('blog.destroy');
Route::post('blog/{blog}/toggle', [AdminBlogController::class, 'toggle'])->name('blog.toggle');

// Blog Categories
Route::get('blog-categories',                    [AdminBlogCategoryController::class, 'index'])->name('blog-categories.index');
Route::post('blog-categories',                   [AdminBlogCategoryController::class, 'store'])->name('blog-categories.store');
Route::delete('blog-categories/{blogCategory}',  [AdminBlogCategoryController::class, 'destroy'])->name('blog-categories.destroy');
    });