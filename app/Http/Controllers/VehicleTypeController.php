<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the vehicle types.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicleTypes = VehicleType::with('taxiService')->get();
        return response()->json(['data' => $vehicleTypes]);
    }

    /**
     * Store a newly created vehicle type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TaxiServiceID' => 'required|exists:TaxiServices,TaxiServiceID',
            'TypeName' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'MaxPassengers' => 'required|integer|min:1',
            'PricePerKm' => 'required|numeric|min:0',
            'BasePrice' => 'required|numeric|min:0',
            'ImageURL' => 'nullable|string',
            'IsActive' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $vehicleType = VehicleType::create($request->all());
            return response()->json(['data' => $vehicleType, 'message' => 'Vehicle type created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to create vehicle type']], 500);
        }
    }

    /**
     * Display the specified vehicle type.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $vehicleType = VehicleType::with(['taxiService', 'vehicles'])->findOrFail($id);
            return response()->json(['data' => $vehicleType]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['errors' => ['Vehicle type not found']], 404);
        }
    }

    /**
     * Update the specified vehicle type in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vehicleType = VehicleType::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'TaxiServiceID' => 'exists:TaxiServices,TaxiServiceID',
            'TypeName' => 'string|max:255',
            'Description' => 'nullable|string',
            'MaxPassengers' => 'integer|min:1',
            'PricePerKm' => 'numeric|min:0',
            'BasePrice' => 'numeric|min:0',
            'ImageURL' => 'nullable|string',
            'IsActive' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $vehicleType->update($request->all());
            return response()->json(['data' => $vehicleType, 'message' => 'Vehicle type updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to update vehicle type']], 500);
        }
    }

    /**
     * Remove the specified vehicle type from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $vehicleType = VehicleType::findOrFail($id);
            $vehicleType->delete();

            return response()->json(['message' => 'Vehicle type deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to delete vehicle type']], 500);
        }
    }

    /**
     * Get vehicle types by taxi service.
     *
     * @param  int  $taxiServiceId
     * @return \Illuminate\Http\Response
     */
    public function getVehicleTypesByTaxiService($taxiServiceId)
    {
        if (empty($taxiServiceId)) {
            return response()->json(['errors' => ['Taxi service ID is required']], 400);
        }

        $vehicleTypes = VehicleType::where('TaxiServiceID', $taxiServiceId)
            ->where('IsActive', true)
            ->get();

        if ($vehicleTypes === null) {
            return response()->json(['errors' => ['Vehicle types not found']], 404);
        }

        return response()->json(['data' => $vehicleTypes]);
    }

    /**
     * Update pricing for a vehicle type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePricing(Request $request, $id)
    {
        $vehicleType = VehicleType::findOrFail($id);

        if ($vehicleType === null) {
            return response()->json(['errors' => ['Vehicle type not found']], 404);
        }

        $validator = Validator::make($request->all(), [
            'PricePerKm' => 'required|numeric|min:0',
            'BasePrice' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $vehicleType->PricePerKm = $request->PricePerKm;
            $vehicleType->BasePrice = $request->BasePrice;
            $vehicleType->save();
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to update vehicle type pricing']], 500);
        }

        return response()->json(['data' => $vehicleType, 'message' => 'Vehicle type pricing updated successfully']);
    }
}
