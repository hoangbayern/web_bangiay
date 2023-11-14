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
            Route::get('/logout', 'logout')->name('logout')->middleware('auth:admin');
            Route::get('/reset', 'showResetPasswordForm')->name('resetPassword');
            Route::get('/change-password', 'changePassword')->name('changePassword')->middleware('auth:admin');
            Route::post('/change-password', 'updatePassword')->name('updatePassword')->middleware('auth:admin');
        });
    });
    Route::controller(AdminForgotPasswordController::class)->group(function (){
        Route::as('admin.')->group(function (){
            Route::get('/forget-password', 'showForgetPasswordForm')->name('forgetPassword');
            Route::post('/forget-password', 'sendResetLinkEmail')->name('sendResetLinkEmail');
            Route::get('/reset-password/{token}', 'resetPassword')->name('resetPassword');
            Route::post('/reset-password', 'resetPasswordPost')->name('resetPasswordPost');
        });
    });
});
