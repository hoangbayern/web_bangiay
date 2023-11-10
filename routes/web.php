<?php
foreach (File::allFiles(__DIR__ ) as $route_file) {
    (basename($route_file =='web.php')) ? : (require_once $route_file);
}


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin', function () {
    return view('admin-home');
})->name('adminHome')->middleware('auth:admin');

Route::get('/', [ClientController::class, 'index'])->name('client.home');
Route::get('/shop/{categorySlug?}', [ShopController::class, 'index'])->name('client.shop');
Route::get('/product/{productName}', [ShopController::class, 'product'])->name('client.product');
Route::get('/cart', [CartController::class, 'cart'])->name('client.cart');
Route::post('/addCart', [CartController::class, 'addCart'])->name('client.addCart');
Route::post('/updateCart', [CartController::class, 'updateCart'])->name('client.updateCart');
Route::post('/deleteCart', [CartController::class, 'deleteItemCart'])->name('client.deleteItemCart');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
