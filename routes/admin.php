<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\SignInController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
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

            //orders
            Route::get('/orders', [OrdersController::class, 'orders'])->name('admin.orders');
            Route::get('/orders/view/{id}', [OrdersController::class, 'viewOrder'])->name('admin.orders.view');
            Route::get('/orders/activate/{id}', [OrdersController::class, 'activateOrder'])->name('admin.orders.activate');
            Route::get('/orders/deactivate/{id}', [OrdersController::class, 'deactivateOrder'])->name('admin.orders.deactivate');
            Route::post('/orders/edit', [OrdersController::class, 'updateOrder'])->name('admin.orders.edit');
            Route::get('/orders/remove/{id}', [OrdersController::class, 'removeOrder'])->name('admin.orders.remove');
            Route::get('/orders/feature/{id}', [OrdersController::class, 'featureOrder'])->name('admin.orders.feature');
            Route::post('orders/update', [OrdersController::class, 'updateOrder'])->name('admin.orders.update');
            Route::delete('orders/{id}', [OrdersController::class, 'removeOrder'])->name('admin.orders.destroy');

            // shipment
            Route::get('/shipment', [ShipmentController::class, 'index'])->name('admin.shipment');
            Route::get('/shipment/create', [ShipmentController::class, 'create'])->name('admin.shipment.create');
            Route::post('/shipment/store', [ShipmentController::class, 'store'])->name('admin.shipment.store');
            Route::get('/shipment/edit/{id}', [ShipmentController::class, 'edit'])->name('admin.shipment.edit');
            Route::post('/shipment/update/{id}', [ShipmentController::class, 'update'])->name('admin.shipment.update');
            Route::delete('/shipment/delete/{id}', [ShipmentController::class, 'destroy'])->name('admin.shipment.destroy');

            // reviews
            // Reviews Routes
            // Reviews Routes - Explicit definitions
            Route::get('/reviews', [ReviewsController::class, 'index'])->name('admin.reviews');
            Route::get('reviews/create', [ReviewsController::class, 'create'])->name('admin.reviews.create');
            Route::post('reviews', [ReviewsController::class, 'store'])->name('admin.reviews.store');
            Route::get('reviews/{review}', [ReviewsController::class, 'show'])->name('admin.reviews.show');
            Route::get('reviews/{review}/edit', [ReviewsController::class, 'edit'])->name('admin.reviews.edit');
            Route::put('reviews/{review}', [ReviewsController::class, 'update'])->name('admin.reviews.update');
            Route::delete('reviews/{review}', [ReviewsController::class, 'destroy'])->name('admin.reviews.destroy');

            // Quick Actions for Reviews
            Route::patch('reviews/{review}/approve', [ReviewsController::class, 'approve'])
                ->name('admin.reviews.approve');
            Route::patch('reviews/{review}/reject', [ReviewsController::class, 'reject'])
                ->name('admin.reviews.reject');
            Route::patch('reviews/{review}/toggle-featured', [ReviewsController::class, 'toggleFeatured'])
                ->name('admin.reviews.toggle-featured');

            // Bulk Actions
            Route::post('reviews/bulk-action', [ReviewsController::class, 'bulkAction'])
                ->name('admin.reviews.bulk-action');


            //country
            Route::get('/countries', [CountryController::class, 'index'])
                ->name('admin.countries');
            Route::get('/countries/new', [CountryController::class, 'newCountry'])->name('admin.countries.new');
            Route::post('/countries/create', [CountryController::class, 'create'])->name('admin.countries.create');
            Route::get('/countries/view/{id}', [CountryController::class, 'viewCountry'])->name('admin.countries.view');
            Route::get('/countries/activate/{id}', [CountryController::class, 'activate'])->name('admin.countries.activate');
            Route::get('/countries/deactivate/{id}', [CountryController::class, 'deactivate'])->name('admin.countries.deactivate');
            Route::post('/countries/edit', [CountryController::class, 'update'])->name('admin.countries.edit');
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
