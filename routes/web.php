<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Route::group(['prefix' => LaravelLocalization::setLocale() , 'middleware' =>  [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ] ], function()
{
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });

        
    require __DIR__.'/auth.php';
    
    require __DIR__.'/adminAuth.php';
    
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth'])->name('dashboard');
    
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});