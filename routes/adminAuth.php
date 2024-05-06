<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->controller(AdminAuthController::class)->group(function () {

  Route::middleware('guest:web,admin')->group(function () {

      Route::post('login', 'login')
      ->name('login');

      Route::get('register', 'registerForm' )
                  ->name('register');

      Route::post('register', 'register');

      Route::get('login', 'loginForm')
                  ->name('loginForm');


    });

});

