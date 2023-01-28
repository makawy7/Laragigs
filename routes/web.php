<?php

use App\Http\Controllers\ListingController;
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
Route::group(['controller' => ListingController::class], function () {
    Route::get('/', 'index')->name('home');
    Route::get('listing/create', 'create')->name('createListing');
    Route::get('listing/{listing}', 'show')->name('showListing');
    Route::get('listing/{listing}/edit', 'edit')->name('editListing');
    Route::put('listing/{listing}', 'update')->name('updateListing');
    Route::delete('listing/{listing}', 'destroy')->name('destroyListing');
    Route::post('listing', 'store')->name('storeListing');
});
