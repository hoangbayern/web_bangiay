<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::prefix('admin/orders')->controller(OrderController::class)->as('order.')->group(function (){
    Route::get('/list', 'listOrder')->name('list')
        ->middleware('auth:admin');
    Route::get('/search', 'search')->name('search')
        ->middleware('auth:admin');
    Route::get('/detail/{id}', 'detail')->name('detail')
        ->middleware('auth:admin');
    Route::post('/change-status/{id}', 'changeOrderStatus')->name('changeOrderStatus')
        ->middleware('auth:admin');
    Route::post('/invoice-email/{id}', 'sendInvoiceEmail')->name('sendInvoiceEmail')
        ->middleware('auth:admin');
});
