<?php
foreach (File::allFiles(__DIR__ ) as $route_file) {
    (basename($route_file =='web.php')) ? : (require_once $route_file);
}


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

//Route::get('/admin', function () {
//    return view('admin-home');
//})->name('adminHome')->middleware('auth:admin');

Route::get('/admin', [AdminController::class, 'homeAdmin'])->name('adminHome')->middleware('auth:admin');

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
Route::post('/add-wishlist', [ClientController::class, 'addWishList'])->name('client.addWishList');
Route::get('/wishlist', [LoginController::class, 'wishlist'])->name('client.wishlist');
Route::post('/remove-wishlist', [LoginController::class, 'removeItemWishlist'])->name('client.removeItemWishlist');

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
    Route::post('/profile', [LoginController::class, 'updateProfile'])->name('client.updateProfile');
    Route::get('/my-orders', [LoginController::class, 'myOrders'])->name('client.myOrders');
    Route::get('/my-orderDetail/{orderId}', [LoginController::class, 'myOrderDetail'])->name('client.myOrderDetail');
    Route::get('/change-password', [LoginController::class, 'changePassword'])->name('client.changePassword');
    Route::post('/change-password', [LoginController::class, 'updatePassword'])->name('client.updatePassword');
});

Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('client.forgetPassword');
Route::post('/forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('client.sendResetLinkEmail');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('client.resetPassword');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPasswordPost'])->name('client.resetPasswordPost');

//Route::get('/test', function (){
//   orderEmail(5);
//});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
