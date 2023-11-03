<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/products')->controller(ProductController::class)->as('product.')->group(function (){
//    Route::get('/list','index')->name('index')
//        ->middleware('auth')
//        ->middleware('permission:product.index');
//    Route::delete('/{id}','destroy')->name('destroy')
//        ->middleware('auth')
//        ->middleware('permission:product.destroy');
    Route::get('/create','showFormCreate')->name('create')
        ->middleware('auth:admin');
    Route::post('/create','store')->name('store')
        ->middleware('auth:admin');
//    Route::get('/edit/{id}','edit')->name('edit')
//        ->middleware('auth')
//        ->middleware('permission:product.update');
//    Route::post('/update/product/{id}','update')->name('update')
//        ->middleware('auth')
//        ->middleware('permission:product.update');
//    Route::get('/show/{id}', 'show')->name('show')
//        ->middleware('auth')
//        ->middleware('permission:product.show');
//    Route::get('/search-product','search')->name('search');
});
