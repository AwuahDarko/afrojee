<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SignInController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    // Route::get('/', function () {
    //     return 'Admin Dashboard';
    // });

    Route::get('/', [SignInController::class, 'index'])->name('admin.signin');
    Route::post('/login', [SignInController::class, 'login'])->name('admin.signin.login');


    Route::middleware(['auth', 'admin'])->group(
        function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('/category', [CategoryController::class, 'index'])->name('admin.categories');
            Route::get('/category/new', [CategoryController::class, 'newCategory'])->name('admin.category.new');
            Route::post('/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
            Route::get('/category/view/{id}', [CategoryController::class, 'viewCategory'])->name('admin.category.view');
            Route::get('/category/activate/{id}', [CategoryController::class, 'activate'])->name('admin.category.activate');
            Route::get('/category/deactivate/{id}', [CategoryController::class, 'deactivate'])->name('admin.category.deactivate');
            Route::post('/category/edit', [CategoryController::class, 'update'])->name('admin.category.edit');


            Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
            Route::get('/products/new', [ProductController::class, 'newProduct'])->name('admin.products.new');
            Route::post('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
            Route::get('/products/view/{id}', [ProductController::class, 'viewProduct'])->name('admin.products.view');
            Route::get('/products/activate/{id}', [ProductController::class, 'activate'])->name('admin.products.activate');
            Route::get('/prroducts/deactivate/{id}', [ProductController::class, 'deactivate'])->name('admin.products.deactivate');
            Route::post('/products/edit', [ProductController::class, 'update'])->name('admin.products.edit');
            Route::get('/products/remove/{id}', [ProductController::class, 'remove'])->name('admin.products.remove');
            Route::get('/prroducts/feature/{id}', [ProductController::class, 'feature'])->name('admin.products.feature');

        }
    );



    // Add more admin routes as needed
    Route::get('/billing', function () {
        return view('backend.temp.billing');
    })->name('admin.billing');

    Route::get('/icons', function () {
        return view('backend.temp.icons');
    })->name('admin.icons');

    Route::get('/tables', function () {
        return view('backend.temp.tables');
    })->name('admin.tables');

    Route::get('/vr', function () {
        return view('backend.temp.virtual-reality');
    })->name('admin.vr');

    Route::get('/notification', function () {
        return view('backend.temp.notification');
    })->name('admin.notification');

    Route::get('/rtl', function () {
        return view('backend.temp.rtl');
    })->name('admin.rtl');

    Route::get('/profile', function () {
        return view('backend.temp.profile');
    })->name('admin.profile');
});