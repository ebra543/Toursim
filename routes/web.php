<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');  // Add the name 'home' to your root route

// Map routes
Route::get('/select-address', [App\Http\Controllers\MapController::class, 'selectAddress'])->name('select.address');
Route::get('/taxi-route', [App\Http\Controllers\MapController::class, 'taxiRoute'])->name('taxi.route');

// Tourism service routes
Route::get('/tours', [App\Http\Controllers\TourController::class, 'index'])->name('tours.index');
Route::get('/hotels', [App\Http\Controllers\HotelController::class, 'index'])->name('hotels.index');
Route::get('/restaurants', [App\Http\Controllers\RestaurantController::class, 'index'])->name('restaurants.index');

// Static pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// API routes for map functionality
Route::prefix('api/map')->group(function () {
    Route::post('/geocode', [App\Http\Controllers\MapController::class, 'geocodeAddress']);
    Route::post('/reverse-geocode', [App\Http\Controllers\MapController::class, 'reverseGeocode']);
    Route::post('/route', [App\Http\Controllers\MapController::class, 'getRoute']);
    Route::post('/places', [App\Http\Controllers\MapController::class, 'searchPlaces']);
});
