<?php

use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\TonerController;
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

Route::get('/', [CatalogueController::class, 'index']);
Route::get('/product-detail/{id}', [CatalogueController::class, 'getByID']);
Route::get('/view-cart', [CatalogueController::class, 'viewCart'])->name('view-cart');
Route::post('/add-to-cart', [CatalogueController::class, 'addToCart']);
Route::post('/cart/update-quantity', [CatalogueController::class, 'updateCartQuantity']);
Route::post('/cart/remove', [CatalogueController::class, 'removeCartItem']);
Route::post('/cart/remove-all', [CatalogueController::class, 'clearCart']);

Route::middleware(['auth'])->group(function () {
    // Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
    Route::get('logout', [TonerController::class, 'logout']);

    Route::get('{any}', [TonerController::class, 'index']);
});

