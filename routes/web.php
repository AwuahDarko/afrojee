<?php

use App\Http\Controllers\Web\OrderController;
use App\Mail\DeliveryMail;
use App\Mail\OrderMail;
use App\Mail\ReceiptMail;
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
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\NewsletterController;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;




Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutUsController::class, 'index'])->name('web.about');
Route::get('/faq', [QuestionsController::class, 'index'])->name('web.questions');
Route::get('/products', [ProductController::class, 'index'])->name('web.products');
Route::get('/products/search', [ProductController::class, 'search'])->name('web.product.search');
Route::get('/products/search2', [ProductController::class, 'search2'])->name('web.product.search2');

Route::get('/products/{slug}', [ProductController::class, 'filterByCategory'])->name('web.products.filterByCategory');
Route::get('/products/details/{slug}', [ProductController::class, 'productDetails'])->name('web.products.details');
Route::get('/profile-management', [ProfileManagementController::class, 'index'])->name('web.profile.management');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('web.checkoutDetails');
// Updated checkout route to accept size_id
Route::get('/checkout/single/{product_id}/{quantity}/{size_id}', [CheckoutController::class, 'single'])->name('web.checkoutDetails.single');
Route::get('/checkout/info/regions', [CheckoutController::class, 'getRegionByCountry'])->name('web.checkoutDetails.info.region');
Route::get('/checkout/info/prices', [CheckoutController::class, 'calculatePrice'])->name('web.checkoutDetails.info.price');
Route::get('/checkout/info/price', [CheckoutController::class, 'getPrice'])->name('web.checkoutDetails.info.getprice');
Route::get('/checkout/info/shipping-methods', [CheckoutController::class, 'getShippingMethods'])->name('web.checkoutDetails.info.shippingMethods');
Route::post('/checkout/validate-weight', [CheckoutController::class, 'validateCartWeight'])->name('web.checkoutDetails.validateWeight');
Route::get('/sign-in', [SignInController::class, 'index'])->name('web.signin');
Route::get('/sign-up', [SignUpController::class, 'index'])->name('web.signup');
// Route::get('/reviews', [ReviewController::class, 'index'])->name('web.review');
// Featured reviews for testimonials section
Route::get('/testimonials', [ReviewController::class, 'index'])->name('reviews.testimonials');
// All reviews page
Route::get('/reviews/all', [ReviewController::class, 'allReviews'])->name('reviews.all');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');

// Get featured reviews (AJAX)
Route::get('/reviews/featured', [ReviewController::class, 'getFeaturedReviews'])->name('reviews.featured');
Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');

// New route for storing a new review (form submission)
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::post('/products/{product}/review', [ProductController::class, 'storeReview'])->name('product.review.store');
Route::get('/cart', [CartController::class, 'index'])->name('web.cart');


// Contact Form Routes
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact-us', [ContactController::class, 'index'])->name('web.contact');

// Newsletter Routes
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
// Original GET route
// Route::get('/checkout', [CheckoutController::class, 'index'])->name('web.checkoutDetails');

// New POST route for handling cart data submission to checkout
Route::post('/checkout', [CheckoutController::class, 'processCartAndShowCheckout'])->name('web.checkoutDetails.post');
Route::post('/checkout/process-cart', [CheckoutController::class, 'processCartAndShowCheckout'])->name('web.checkout.processCart');
Route::post('/checkout/save-address', [CheckoutController::class, 'storeAddress'])->name('web.checkout.saveAddress'); // This is the missing one!


// orders
Route::post('/order/single/save', [OrderController::class, 'store'])->name('web.order.save');
Route::post('/order/multiple/save', [OrderController::class, 'storeMultiple'])->name('web.order.multiple.save');


// stripe checkout
// Route::get('/checkout/stripe', [CheckoutController::class, 'create'])->name('checkout.create.stripe');
Route::get('/checkout/stripe/success', [CheckoutController::class, 'stripeSuccess'])->name('checkout.success.stripe');
Route::get('/checkout/stripe/cancel',  [CheckoutController::class, 'stripeCancel'])->name('checkout.cancel.stripe');
Route::post('/stripe/webhook', [CheckoutController::class, 'webhook'])
      ->name('stripe.webhook');


// Or, if you want the original route to also handle POST:
// Route::match(['GET', 'POST'], '/checkout', [CheckoutController::class, 'index'])->name('web.checkoutDetails');

Route::get('/send-test-email', function () {
//     $data = ['name' => 'Dev Jav'];
    $data = [
    'customer_name' => 'Kwame',
    'customer_email' => 'Kwame@email.com',
    'order_id' => 'AFR123456',
    'amount' => '150.00',
    'payment_method' => 'Mobile Money',
    'status' => 'Out for Delivery',
    'estimated_delivery_date' => '2025-07-05',
    'total' => 3400,
    'order_time' => 'Once upon a time'
];

//     Mail::to(['mjadarko@gmail.com', 'max.seven.work@gmail.com'])->send(new TestMail($data));
//     Mail::to(['mjadarko@gmail.com', 'max.seven.work@gmail.com'])->send(new ReceiptMail($data));
//     Mail::to(['mjadarko@gmail.com', 'max.seven.work@gmail.com'])->send(new DeliveryMail($data));


       Mail::to(['mjadarko@gmail.com', 'max.seven.work@gmail.com'])->queue(new OrderMail($data));

    return 'Email sent!';
});
