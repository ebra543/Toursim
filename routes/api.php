<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User Management Routes
Route::prefix('users')->group(function () {
    // Routes will be implemented here
});

// Location Management Routes
Route::prefix('locations')->group(function () {
    // Routes will be implemented here
});

// Tour Management Routes
Route::prefix('tours')->group(function () {
    // Routes will be implemented here
});

// Hotel Management Routes
Route::prefix('hotels')->group(function () {
    // Routes will be implemented here
});

// Restaurant Management Routes
Route::prefix('restaurants')->group(function () {
    // Routes will be implemented here
});

// Taxi Service Management Routes
Route::prefix('taxi-services')->group(function () {
    Route::get('/', [App\Http\Controllers\TaxiServiceController::class, 'index']);
    Route::post('/', [App\Http\Controllers\TaxiServiceController::class, 'store']);
    Route::get('/{id}', [App\Http\Controllers\TaxiServiceController::class, 'show']);
    Route::put('/{id}', [App\Http\Controllers\TaxiServiceController::class, 'update']);
    Route::delete('/{id}', [App\Http\Controllers\TaxiServiceController::class, 'destroy']);
    Route::get('/active', [App\Http\Controllers\TaxiServiceController::class, 'getActiveTaxiServices']);
    Route::get('/location/{locationId}', [App\Http\Controllers\TaxiServiceController::class, 'getTaxiServicesByLocation']);

    // Vehicle Types Routes
    Route::prefix('vehicle-types')->group(function () {
        Route::get('/', [App\Http\Controllers\VehicleTypeController::class, 'index']);
        Route::post('/', [App\Http\Controllers\VehicleTypeController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\VehicleTypeController::class, 'show']);
        Route::put('/{id}', [App\Http\Controllers\VehicleTypeController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\VehicleTypeController::class, 'destroy']);
        Route::get('/service/{taxiServiceId}', [App\Http\Controllers\VehicleTypeController::class, 'getVehicleTypesByTaxiService']);
        Route::put('/{id}/pricing', [App\Http\Controllers\VehicleTypeController::class, 'updatePricing']);
    });

    // Vehicles Routes
    Route::prefix('vehicles')->group(function () {
        Route::get('/', [App\Http\Controllers\VehicleController::class, 'index']);
        Route::post('/', [App\Http\Controllers\VehicleController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\VehicleController::class, 'show']);
        Route::put('/{id}', [App\Http\Controllers\VehicleController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\VehicleController::class, 'destroy']);
        Route::get('/service/{taxiServiceId}', [App\Http\Controllers\VehicleController::class, 'getVehiclesByTaxiService']);
        Route::get('/type/{vehicleTypeId}', [App\Http\Controllers\VehicleController::class, 'getVehiclesByType']);
        Route::post('/available', [App\Http\Controllers\VehicleController::class, 'getAvailableVehicles']);
    });

    // Drivers Routes
    Route::prefix('drivers')->group(function () {
        Route::get('/', [App\Http\Controllers\DriverController::class, 'index']);
        Route::post('/', [App\Http\Controllers\DriverController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\DriverController::class, 'show']);
        Route::put('/{id}', [App\Http\Controllers\DriverController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\DriverController::class, 'destroy']);
        Route::get('/service/{taxiServiceId}', [App\Http\Controllers\DriverController::class, 'getDriversByTaxiService']);
        Route::post('/available', [App\Http\Controllers\DriverController::class, 'getAvailableDrivers']);
        Route::put('/{id}/rating', [App\Http\Controllers\DriverController::class, 'updateRating']);
    });

    // Taxi Bookings Routes
    Route::prefix('bookings')->group(function () {
        Route::get('/', [App\Http\Controllers\TaxiBookingController::class, 'index']);
        Route::post('/', [App\Http\Controllers\TaxiBookingController::class, 'store']);
        Route::get('/{id}', [App\Http\Controllers\TaxiBookingController::class, 'show']);
        Route::put('/{id}', [App\Http\Controllers\TaxiBookingController::class, 'update']);
        Route::delete('/{id}', [App\Http\Controllers\TaxiBookingController::class, 'destroy']);
        Route::post('/calculate-fare', [App\Http\Controllers\TaxiBookingController::class, 'calculateFare']);
        Route::get('/user/{userId}', [App\Http\Controllers\TaxiBookingController::class, 'getBookingsByUser']);
        Route::put('/{id}/assign', [App\Http\Controllers\TaxiBookingController::class, 'assignDriverAndVehicle']);
    });
});

// Travel Agency Management Routes
Route::prefix('travel-agencies')->group(function () {
    // Routes will be implemented here
});

// Booking Management Routes
Route::prefix('bookings')->group(function () {
    // Routes will be implemented here
});

// Payment Management Routes
Route::prefix('payments')->group(function () {
    // Routes will be implemented here
});

// Rating and Feedback Routes
Route::prefix('ratings')->group(function () {
    // Routes will be implemented here
});

// Promotions and Marketing Routes
Route::prefix('promotions')->group(function () {
    // Routes will be implemented here
});

// System Management Routes
Route::prefix('system')->group(function () {
    // Routes will be implemented here
});
