<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the drivers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Driver::with(['user', 'taxiService'])->get();
        return response()->json(['data' => $drivers]);
    }

    /**
     * Store a newly created driver in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'UserID' => 'required|exists:users,UserID',
            'TaxiServiceID' => 'required|exists:TaxiServices,TaxiServiceID',
            'LicenseNumber' => 'required|string|unique:Drivers,LicenseNumber',
            'ExperienceYears' => 'nullable|integer',
            'Rating' => 'nullable|numeric|min:0|max:5',
            'IsActive' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $driver = Driver::create($request->all());
        return response()->json(['data' => $driver, 'message' => 'Driver created successfully'], 201);
    }

    /**
     * Display the specified driver.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = Driver::with(['user', 'taxiService'])->findOrFail($id);
        return response()->json(['data' => $driver]);
    }

    /**
     * Update the specified driver in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'UserID' => 'exists:users,UserID',
            'TaxiServiceID' => 'exists:TaxiServices,TaxiServiceID',
            'LicenseNumber' => 'string|unique:Drivers,LicenseNumber,' . $id . ',DriverID',
            'ExperienceYears' => 'nullable|integer',
            'Rating' => 'nullable|numeric|min:0|max:5',
            'IsActive' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $driver->update($request->all());
        return response()->json(['data' => $driver, 'message' => 'Driver updated successfully']);
    }

    /**
     * Remove the specified driver from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        return response()->json(['message' => 'Driver deleted successfully']);
    }

    /**
     * Get drivers by taxi service.
     *
     * @param  int  $taxiServiceId
     * @return \Illuminate\Http\Response
     */
    public function getDriversByTaxiService($taxiServiceId)
    {
        $drivers = Driver::where('TaxiServiceID', $taxiServiceId)
            ->where('IsActive', true)
            ->with(['user'])
            ->get();

        return response()->json(['data' => $drivers]);
    }

    /**
     * Get available drivers for booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAvailableDrivers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TaxiServiceID' => 'required|exists:TaxiServices,TaxiServiceID',
            'BookingDateTime' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $drivers = Driver::where('TaxiServiceID', $request->TaxiServiceID)
            ->where('IsActive', true)
            ->with(['user'])
            ->get();

        // Here we would add logic to check if the driver is already assigned to another booking at the requested time
        // This would involve checking the TaxiBookings table

        return response()->json(['data' => $drivers]);
    }

    /**
     * Update driver rating.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRating(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'Rating' => 'required|numeric|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Calculate new average rating
        $newRating = $request->Rating;
        $driver->Rating = $newRating;
        $driver->save();

        return response()->json(['data' => $driver, 'message' => 'Driver rating updated successfully']);
    }
}
