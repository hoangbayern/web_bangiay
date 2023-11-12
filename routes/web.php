<?php
foreach (File::allFiles(__DIR__ ) as $route_file) {
    (basename($route_file =='web.php')) ? : (require_once $route_file);
}


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\LoginController;

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
Route::get('/checkout', [CartController::class, 'checkout'])->name('client.checkout');
Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('client.processCheckout');
Route::get('/thanks/{orderId}', [CartController::class, 'thankOrder'])->name('client.thanks');

//Authenticate Client
Route::group(['middleware' => 'guest'], function (){
    Route::get('/loginClient', [LoginController::class, 'showLoginForm'])->name('client.login');
    Route::post('/loginClient', [LoginController::class, 'loginClient'])->name('client.postLoginClient');
    Route::get('/registerClient', [LoginController::class, 'showRegisterForm'])->name('client.register');
    Route::post('/registerClient', [LoginController::class, 'registerClient'])->name('client.postRegisterClient');
});
Route::group(['middleware' => 'auth'], function (){
    Route::get('/logoutClient', [LoginController::class, 'logoutClient'])->name('client.logoutClient');
    Route::get('/profile', [LoginController::class, 'profile'])->name('client.profile');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
