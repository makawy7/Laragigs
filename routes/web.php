<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('listing/{listing}', [ListingController::class, 'show'])->name('showListing');
Route::group(['controller' => ListingController::class, 'middleware' => 'auth'], function () {
    Route::get('/', 'index')->name('home')->withoutMiddleware('auth');
    Route::get('listing/create', 'create')->name('createListing');
    Route::get('listing/{listing}', 'show')->name('showListing')->withoutMiddleware('auth');
    Route::get('listing/{listing}/edit', 'edit')->name('editListing')->middleware('creatorof');
    Route::put('listing/{listing}', 'update')->name('updateListing')->middleware('creatorof');
    Route::delete('listing/{listing}', 'destroy')->name('destroyListing')->middleware('creatorof');
    Route::post('listing', 'store')->name('storeListing');
    Route::get('manage', 'manage')->name('manage');
});


Route::controller(UserController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'authenticate')->name('authenticate');
        Route::get('register', 'register')->name('register');
        Route::post('register', 'store')->name('storeUser');
    });
    Route::post('logout', 'logout')->name('logout')->middleware('auth');
});
