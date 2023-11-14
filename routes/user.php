<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('admin/users')->controller(UserController::class)->as('user.')->group(function (){
    Route::get('/list', 'listUser')->name('list')
        ->middleware('auth:admin');
    Route::get('/search', 'search')->name('search')
        ->middleware('auth:admin');
    Route::get('/edit/{id}','showFormEdit')->name('edit')
        ->middleware('auth:admin');
    Route::post('/update/{id}','update')->name('update')
        ->middleware('auth:admin');
    Route::delete('/{id}', 'deleteUser')->name('delete')
        ->middleware('auth:admin');
});
