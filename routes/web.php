<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::group(['prefix' => LaravelLocalization::setLocale() , 'middleware' =>  [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] ], function()
{

    require __DIR__.'/auth.php';
    
    require __DIR__.'/adminAuth.php';

	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });

    Route::middleware('auth:web,admin')->group(function () {
        Route::get('/lang-test', function () {
            return Inertia::render('LangTest');
        })->name('lang-test');
        
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
    });

    
    Route::middleware('auth:web,admin')->controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::middleware('auth:web,admin')->controller(OTPController::class)->group(function () {
        Route::get('/otp-test', 'test')->name('otp.test');
        Route::get('/otp-send', 'send')->name('otp.send');
        Route::post('/otp-check', 'check')->name('otp.check');
    });

    Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {

        Route::group(['middleware' => 'auth:admin'], function () {
            Route::post('/', 'store')->name('store');
            Route::get('/create', 'create')->name('create');
            Route::get('/{product}/edit', 'edit')->name('edit');
            Route::patch('/{product}', 'update')->name('update');
            Route::delete('/{product}', 'destroy')->name('destroy');
        });

        Route::group(['middleware' => 'auth:admin,web'], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/search', 'search')->name('search');
            Route::post('/searchResult', 'searchResult')->name('search.result');
            Route::get('/{product}', 'show')->name('show');
        });

    });

    Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function () {

        Route::group(['middleware' => 'auth:admin'], function () {
            Route::post('/', 'store')->name('store');
            Route::get('/create', 'create')->name('create');
        });

    });

    Route::prefix('payments')->name('payments.')->controller(PaymentController::class)->group(function () {

        Route::group(['middleware' => 'auth'], function () {
            Route::post('/chekout', 'checkout')->name('checkout');
            Route::get('/success', 'success')->name('success');
            Route::get('/cancel', 'cancel')->name('cancel');
        });

    });

});