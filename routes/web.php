<?php

use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\TonerController;
use App\Http\Controllers\ArticleController;
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

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Auth::routes();

Route::get('/', [LandingPageController::class, 'index'])->name('index');
Route::get('/catalogue', [CatalogueController::class, 'index'])->name('index');
Route::get('/product-detail/{id}', [CatalogueController::class, 'getByID']);
Route::get('/view-cart', [CatalogueController::class, 'viewCart'])->name('view-cart');
Route::post('/add-to-cart', [CatalogueController::class, 'addToCart']);
Route::post('/cart/update-quantity', [CatalogueController::class, 'updateCartQuantity']);
Route::post('/cart/remove', [CatalogueController::class, 'removeCartItem']);
Route::post('/cart/remove-all', [CatalogueController::class, 'clearCart']);
Route::post('/cart/validate-stock', [CatalogueController::class, 'validateCartBeforeCheckout'])->name('cart.validate-stock');
Route::post('/buy-now', [CatalogueController::class, 'buyNow']);
Route::get('/checkout', [CatalogueController::class, 'viewCheckout'])->name('checkout.page');
Route::post('/checkout', [CatalogueController::class, 'createOrder'])->name('create-order');
Route::get('/payment/confirmation/{invoiceNo}', [CheckoutController::class, 'showPaymentConfirmation'])->name('payment.confirmation');
Route::post('/payment/confirmation/{invoiceNo}/upload', [CheckoutController::class, 'uploadPaymentProof'])->name('payment.confirmation.upload');
Route::post('/calculate-shipping', [CheckoutController::class, 'calculateShipping']);
Route::get('/checkout-success/{invoiceNo}', [CheckoutController::class, 'viewSuccess'])->name('payment.success');
Route::get('/checkout-failed/{invoiceNo}', [CheckoutController::class, 'viewFailed'])->name('payment.failed');

Route::get('/a-story-of-love', [ArticleController::class, 'aStoryOfLove'])->name('article.story-of-love');
Route::get('/frequently-asked-questions', [ArticleController::class, 'frequentlyAskedQuestions'])->name('article.frequently-asked-questions');
Route::get('/contact-us', [ArticleController::class, 'contactUs'])->name('article.contact-us');
Route::get('/e-commerce-term-and-condition', [ArticleController::class, 'eCommerceTermAndCondition'])->name('article.e-commerce-term-and-condition');

Route::middleware(['auth'])->group(function () {
    // Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    Route::get('logout', [TonerController::class, 'logout']);

    Route::get('{any}', [TonerController::class, 'index']);
});

