<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;

Route::prefix('admin/sizes')->controller(SizeController::class)->as('size.')->group(function (){
    Route::get('/create','showFormCreate')->name('create')
        ->middleware('auth:admin');
    Route::post('/create','store')->name('store')
        ->middleware('auth:admin');
    Route::get('/edit/{id}','showFormEdit')->name('edit')
        ->middleware('auth:admin');
    Route::post('/update/{id}','update')->name('update')
        ->middleware('auth:admin');
    Route::delete('/{id}', 'deleteSize')->name('delete')
        ->middleware('auth:admin');
    Route::get('/list','listSize')->name('list')
        ->middleware('auth:admin');
    Route::get('/search', 'search')->name('search')
        ->middleware('auth:admin');
});

