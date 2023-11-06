<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TempImageController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/products')->controller(ProductController::class)->as('product.')->group(function (){
    Route::get('/create','showFormCreate')->name('create')
        ->middleware('auth:admin');
    Route::post('/create','store')->name('store')
        ->middleware('auth:admin');
    Route::get('/edit/{id}','showFormEdit')->name('edit')
        ->middleware('auth:admin');
    Route::post('/update/{id}','update')->name('update')
        ->middleware('auth:admin');
    Route::delete('/{id}','deleteProduct')->name('delete')
        ->middleware('auth:admin');
    Route::get('/list','listProduct')->name('list')
        ->middleware('auth:admin');
    Route::get('/search', 'search')->name('search')
        ->middleware('auth:admin');
//    Route::get('/show/{id}', 'show')->name('show')
//        ->middleware('auth')
//        ->middleware('permission:product.show');
//    Route::get('/search-product','search')->name('search');
});
Route::prefix('admin/products')->controller(TempImageController::class)->as('temp-images.')->group(function (){
    Route::post('/temp-images','store')->name('create')
        ->middleware('auth:admin');
});
Route::prefix('admin/products')->controller(ProductImageController::class)->as('product-images.')->group(function (){
    Route::post('/product-images','update')->name('update')
        ->middleware('auth:admin');
    Route::delete('/product-images/{id}','destroy')->name('delete')
        ->middleware('auth:admin');
});
