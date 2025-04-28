<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Services\Vehicle\VehicleService;
use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleController extends Controller
{
    protected $vehicleService;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\Vehicle\VehicleService  $vehicleService
     * @return void
     */
    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * Display a listing of the vehicles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $vehicles = $this->vehicleService->getAllVehicles();
            return response()->json(['data' => $vehicles]);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to retrieve vehicles']], 500);
        }
    }

    /**
     * Store a newly created vehicle in storage.
     *
     * @param  \App\Http\Requests\Vehicle\StoreVehicleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVehicleRequest $request)
    {
        try {
            $vehicle = $this->vehicleService->createVehicle($request->validated());
            return response()->json(['data' => $vehicle, 'message' => 'Vehicle created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to create vehicle: ' . $e->getMessage()]], 500);
        }
    }

    /**
     * Display the specified vehicle.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $vehicle = $this->vehicleService->getVehicleById($id);
            return response()->json(['data' => $vehicle]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => ['Vehicle not found']], 404);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to retrieve vehicle']], 500);
        }
    }

    /**
     * Update the specified vehicle in storage.
     *
     * @param  \App\Http\Requests\Vehicle\UpdateVehicleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVehicleRequest $request, $id)
    {
        try {
            $vehicle = $this->vehicleService->updateVehicle($id, $request->validated());
            return response()->json(['data' => $vehicle, 'message' => 'Vehicle updated successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => ['Vehicle not found']], 404);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to update vehicle: ' . $e->getMessage()]], 500);
        }
    }

    /**
     * Remove the specified vehicle from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->vehicleService->deleteVehicle($id);
            return response()->json(['message' => 'Vehicle deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => ['Vehicle not found']], 404);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to delete vehicle: ' . $e->getMessage()]], 500);
        }
    }

    /**
     * Get vehicles by taxi service.
     *
     * @param  int  $taxiServiceId
     * @return \Illuminate\Http\Response
     */
    public function getVehiclesByTaxiService($taxiServiceId)
    {
        try {
            $vehicles = $this->vehicleService->getVehiclesByTaxiService($taxiServiceId);
            return response()->json(['data' => $vehicles]);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to retrieve vehicles']], 500);
        }
    }

    /**
     * Get vehicles by vehicle type.
     *
     * @param  int  $vehicleTypeId
     * @return \Illuminate\Http\Response
     */
    public function getVehiclesByType($vehicleTypeId)
    {
        try {
            $vehicles = $this->vehicleService->getVehiclesByType($vehicleTypeId);
            return response()->json(['data' => $vehicles]);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to retrieve vehicles']], 500);
        }
    }

    /**
     * Get available vehicles for booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAvailableVehicles(Request $request)
    {
        try {
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'TaxiServiceID' => 'required|exists:TaxiServices,TaxiServiceID',
                'VehicleTypeID' => 'required|exists:VehicleTypes,VehicleTypeID',
                'BookingDateTime' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $vehicles = $this->vehicleService->getAvailableVehicles(
                $request->TaxiServiceID,
                $request->VehicleTypeID,
                $request->BookingDateTime
            );

            return response()->json(['data' => $vehicles]);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to retrieve vehicles: ' . $e->getMessage()]], 500);
        }
    }
}
