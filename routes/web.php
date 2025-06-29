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
use App\Http\Controllers\Web\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutUsController::class, 'index'])->name('web.about');
Route::get('/faq', [QuestionsController::class, 'index'])->name('web.questions');
Route::get('/products', [ProductController::class, 'index'])->name('web.products');
Route::get('/products/search', [ProductController::class, 'search'])->name('web.product.search');
Route::get('/products/{slug}', [ProductController::class, 'filterByCategory'])->name('web.products.filterByCategory');
Route::get('/products/details/{slug}', [ProductController::class, 'productDetails'])->name('web.products.details');
Route::get('/profile-management', [ProfileManagementController::class, 'index'])->name('web.profile.management');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('web.checkoutDetails');
Route::get('/checkout/single/{product_id}/{quantity}', [CheckoutController::class, 'single'])->name('web.checkoutDetails.single');
Route::get('/checkout/info/regions', [CheckoutController::class, 'getRegionByCountry'])->name('web.checkoutDetails.info.region');
Route::get('/checkout/info/prices', [CheckoutController::class, 'calculatePrice'])->name('web.checkoutDetails.info.price');
Route::get('/checkout/info/price', [CheckoutController::class, 'getPrice'])->name('web.checkoutDetails.info.getprice');
Route::get('/sign-in', [SignInController::class, 'index'])->name('web.signin');
Route::get('/sign-up', [SignUpController::class, 'index'])->name('web.signup');
Route::get('/reviews', [ReviewController::class, 'index'])->name('web.review');
// Featured reviews for testimonials section
Route::get('/testimonials', [ReviewController::class, 'index'])->name('reviews.testimonials');
// All reviews page
Route::get('/reviews', [ReviewController::class, 'allReviews'])->name('reviews.all');
// API endpoint for AJAX requests (optional)
Route::get('/api/reviews/featured', [ReviewController::class, 'getFeaturedReviews'])->name('api.reviews.featured');
Route::get('/cart', [CartController::class, 'index'])->name('web.cart');
// Original GET route
// Route::get('/checkout', [CheckoutController::class, 'index'])->name('web.checkoutDetails');

// New POST route for handling cart data submission to checkout
Route::post('/checkout', [CheckoutController::class, 'processCartAndShowCheckout'])->name('web.checkoutDetails.post');
Route::post('/checkout/process-cart', [CheckoutController::class, 'processCartAndShowCheckout'])->name('web.checkout.processCart');
Route::post('/checkout/save-address', [CheckoutController::class, 'storeAddress'])->name('web.checkout.saveAddress'); // This is the missing one!

// Or, if you want the original route to also handle POST:
// Route::match(['GET', 'POST'], '/checkout', [CheckoutController::class, 'index'])->name('web.checkoutDetails');

