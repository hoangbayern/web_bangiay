<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TempImageController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/products')->controller(ProductController::class)->as('product.')->group(function (){
    Route::get('/create','showFormCreate')->name('create')
        ->middleware('auth:admin');
    Route::post('/create','store')->name('store')
        ->middleware('auth:admin');
    Route::get('/list','listProduct')->name('list')
        ->middleware('auth:admin');
    Route::get('/search', 'search')->name('search')
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
Route::prefix('admin/products')->controller(TempImageController::class)->as('temp-images.')->group(function (){
    Route::post('/temp-images','store')->name('create')
        ->middleware('auth:admin');
});
