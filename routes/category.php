<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::prefix('admin/categories')->controller(CategoryController::class)->as('category.')->group(function (){
    Route::get('/create','create')->name('create')
        ->middleware('auth:admin');
    Route::post('/create','store')->name('store')
        ->middleware('auth:admin');
    Route::get('/edit/{id}','showFormEdit')->name('showFormEdit')
        ->middleware('auth:admin');
    Route::post('/update/{id}','update')->name('update')
        ->middleware('auth:admin');
    Route::delete('/{id}', 'deleteCategory')->name('delete')
        ->middleware('auth:admin');
    Route::get('/list','listCategory')->name('list')
        ->middleware('auth:admin');
    Route::get('/search', 'search')->name('search')
        ->middleware('auth:admin');
});

