<?php

namespace App\Services\Vehicle;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleService
{
    /**
     * Get all vehicles
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllVehicles(): Collection
    {
        return Vehicle::with(['taxiService', 'vehicleType'])->get();
    }

    /**
     * Get a vehicle by ID
     *
     * @param int $id
     * @return \App\Models\Vehicle
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getVehicleById(int $id): Vehicle
    {
        return Vehicle::with(['taxiService', 'vehicleType'])->findOrFail($id);
    }

    /**
     * Get vehicles by taxi service
     *
     * @param int $taxiServiceId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVehiclesByTaxiService(int $taxiServiceId): Collection
    {
        return Vehicle::where('TaxiServiceID', $taxiServiceId)
            ->where('IsActive', true)
            ->with(['vehicleType'])
            ->get();
    }

    /**
     * Get vehicles by vehicle type
     *
     * @param int $vehicleTypeId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getVehiclesByType(int $vehicleTypeId): Collection
    {
        return Vehicle::where('VehicleTypeID', $vehicleTypeId)
            ->where('IsActive', true)
            ->with(['taxiService'])
            ->get();
    }

    /**
     * Get available vehicles for booking
     *
     * @param int $taxiServiceId
     * @param int $vehicleTypeId
     * @param string $bookingDateTime
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableVehicles(int $taxiServiceId, int $vehicleTypeId, string $bookingDateTime): Collection
    {
        // Get all active vehicles for the taxi service and vehicle type
        $vehicles = Vehicle::where('TaxiServiceID', $taxiServiceId)
            ->where('VehicleTypeID', $vehicleTypeId)
            ->where('IsActive', true)
            ->with(['vehicleType'])
            ->get();

        // Here we would add logic to check if the vehicle is already assigned to another booking at the requested time
        // This would involve checking the TaxiBookings table
        // For now, we're just returning all active vehicles

        return $vehicles;
    }

    /**
     * Create a new vehicle
     *
     * @param array $data
     * @return \App\Models\Vehicle
     * @throws \Exception
     */
    public function createVehicle(array $data): Vehicle
    {
        try {
            return DB::transaction(function () use ($data) {
                return Vehicle::create($data);
            });
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while creating vehicle: ' . $e->getMessage());
        }
    }

    /**
     * Update a vehicle
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Vehicle
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function updateVehicle(int $id, array $data): Vehicle
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $vehicle = Vehicle::findOrFail($id);
                $vehicle->update($data);
                return $vehicle->fresh();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Vehicle not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while updating vehicle: ' . $e->getMessage());
        }
    }

    /**
     * Delete a vehicle
     *
     * @param int $id
     * @return bool
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function deleteVehicle(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $vehicle = Vehicle::findOrFail($id);
                return $vehicle->delete();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Vehicle not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while deleting vehicle: ' . $e->getMessage());
        }
    }
}
