<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\AboutUsController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\ProfileManagementController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\SignInController;
use App\Http\Controllers\Web\SignUpController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\QuestionsController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutUsController::class, 'index'])->name('web.about');
Route::get('/faq', [QuestionsController::class, 'index'])->name('web.questions');
Route::get('/products', [ProductController::class, 'index'])->name('web.products');
Route::get('/products/search', [ProductController::class, 'search'])->name('web.product.search');
Route::get('/products/{slug}', [ProductController::class, 'filterByCategory'])->name('web.products.filterByCategory');
Route::get('/products/details/{slug}', [ProductController::class, 'productDetails'])->name('web.products.details');
Route::get('/profile-management', [ProfileManagementController::class, 'index'])->name('web.profile.management');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('web.checkoutDetails');
Route::get('/sign-in', [SignInController::class, 'index'])->name('web.signin');
Route::get('/sign-up', [SignUpController::class, 'index'])->name('web.signup');
Route::get('/reviews', [ReviewController::class, 'index'])->name('web.review');
