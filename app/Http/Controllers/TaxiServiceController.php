<?php

namespace App\Http\Controllers;

use App\Models\TaxiService;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaxiServiceController extends Controller
{
    /**
     * Display a listing of the taxi services.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taxiServices = TaxiService::with('location')->get();
        if ($taxiServices->isEmpty()) {
            return response()->json(['message' => 'No taxi services found'], 404);
        }
        return response()->json(['data' => $taxiServices]);
    }

    /**
     * Store a newly created taxi service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ServiceName' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'LocationID' => 'required|exists:Locations,LocationID',
            'LogoURL' => 'nullable|string',
            'Website' => 'nullable|string|url',
            'Phone' => 'nullable|string',
            'Email' => 'nullable|email',
            'IsActive' => 'boolean',
            'ManagerID' => 'nullable|exists:users,UserID',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $taxiService = TaxiService::create($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while creating taxi service'], 500);
        }

        return response()->json(['data' => $taxiService, 'message' => 'Taxi service created successfully'], 201);
    }

    /**
     * Display the specified taxi service.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $taxiService = TaxiService::with(['location', 'vehicles', 'drivers', 'vehicleTypes'])->findOrFail($id);
        return response()->json(['data' => $taxiService]);
    }

    /**
     * Update the specified taxi service in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $taxiService = TaxiService::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ServiceName' => 'string|max:255',
            'Description' => 'nullable|string',
            'LocationID' => 'exists:Locations,LocationID',
            'LogoURL' => 'nullable|string',
            'Website' => 'nullable|string|url',
            'Phone' => 'nullable|string',
            'Email' => 'nullable|email',
            'IsActive' => 'boolean',
            'ManagerID' => 'nullable|exists:users,UserID',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $taxiService->update($request->all());
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while updating taxi service'], 500);
        }

        return response()->json(['data' => $taxiService, 'message' => 'Taxi service updated successfully']);
    }

    /**
     * Remove the specified taxi service from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $taxiService = TaxiService::findOrFail($id);

        try {
            $taxiService->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while deleting taxi service'], 500);
        }

        return response()->json(['message' => 'Taxi service deleted successfully']);
    }

    /**
     * Get all active taxi services.
     *
     * @return \Illuminate\Http\Response
     */
    public function getActiveTaxiServices()
    {
        $taxiServices = TaxiService::where('IsActive', true)->with('location')->get();
        if ($taxiServices->isEmpty()) {
            return response()->json(['message' => 'No active taxi services found'], 404);
        }
        return response()->json(['data' => $taxiServices]);
    }

    /**
     * Get taxi services by location.
     *
     * @param  int  $locationId
     * @return \Illuminate\Http\Response
     */
    public function getTaxiServicesByLocation($locationId)
    {
        $taxiServices = TaxiService::where('LocationID', $locationId)
            ->where('IsActive', true)
            ->with('location')
            ->get();

        if ($taxiServices->isEmpty()) {
            return response()->json(['message' => 'No taxi services found for this location'], 404);
        }

        return response()->json(['data' => $taxiServices]);
    }
}
