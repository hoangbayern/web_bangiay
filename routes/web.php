<?php
foreach (File::allFiles(__DIR__ ) as $route_file) {
    (basename($route_file =='web.php')) ? : (require_once $route_file);
}


use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('');
})->name('');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
