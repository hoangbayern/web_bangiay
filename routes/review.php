<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewController;

Route::prefix('admin/reviews')->controller(ReviewController::class)->as('review.')->group(function (){
    Route::get('/list', 'listReview')->name('list')
        ->middleware('auth:admin');
    Route::get('/search', 'search')->name('search')
        ->middleware('auth:admin');
    Route::get('/detail/{id}', 'detail')->name('detail')
        ->middleware('auth:admin');
    Route::post('/update/{id}','changeOrderStatus')->name('changeOrderStatus')
        ->middleware('auth:admin');
});
