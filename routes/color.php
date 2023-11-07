<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;

Route::prefix('admin/colors')->controller(ColorController::class)->as('color.')->group(function (){
    Route::get('/create','showFormCreate')->name('create')
        ->middleware('auth:admin');
    Route::post('/create','store')->name('store')
        ->middleware('auth:admin');
    Route::get('/edit/{id}','showFormEdit')->name('edit')
        ->middleware('auth:admin');
    Route::post('/update/{id}','update')->name('update')
        ->middleware('auth:admin');
    Route::delete('/{id}', 'deleteColor')->name('delete')
        ->middleware('auth:admin');
    Route::get('/list','listColor')->name('list')
        ->middleware('auth:admin');
    Route::get('/search', 'search')->name('search')
        ->middleware('auth:admin');
});

