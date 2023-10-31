<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;

Route::prefix('admin')->group(function (){
    Route::controller(AdminLoginController::class)->group(function (){
        Route::as('admin.')->group(function (){
            Route::get('/login', 'showLoginForm')->name('login');
            Route::post('/login', 'login')->name('postLogin');
            Route::get('/register', 'showRegisterForm')->name('register');
            Route::post('/register', 'register')->name('postRegister');
            Route::get('/logout', 'logout')->name('logout');
            Route::get('/reset', 'showResetPasswordForm')->name('resetPassword');
        });
    });
    Route::controller(AdminForgotPasswordController::class)->group(function (){
        Route::as('admin.')->group(function (){
            Route::get('/reset-password', 'showResetPasswordForm')->name('resetPassword');
            Route::post('/reset-password', 'sendResetLinkEmail')->name('sendResetLinkEmail');
        });
    });
});
