<?php

use App\Http\Controllers\ProductController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
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
    
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth:web,admin'])->name('dashboard');
    
    Route::middleware('auth:web,admin')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

});