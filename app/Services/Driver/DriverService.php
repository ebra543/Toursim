<?php

namespace App\Services\Driver;

use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DriverService
{
    /**
     * Get all drivers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllDrivers(): Collection
    {
        return Driver::with(['user', 'taxiService'])->get();
    }

    /**
     * Get a driver by ID
     *
     * @param int $id
     * @return \App\Models\Driver
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getDriverById(int $id): Driver
    {
        return Driver::with(['user', 'taxiService'])->findOrFail($id);
    }

    /**
     * Get drivers by taxi service
     *
     * @param int $taxiServiceId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDriversByTaxiService(int $taxiServiceId): Collection
    {
        return Driver::where('TaxiServiceID', $taxiServiceId)
            ->where('IsActive', true)
            ->with(['user'])
            ->get();
    }

    /**
     * Get available drivers for booking
     *
     * @param int $taxiServiceId
     * @param string $bookingDateTime
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableDrivers(int $taxiServiceId, string $bookingDateTime): Collection
    {
        // Get all active drivers for the taxi service
        $drivers = Driver::where('TaxiServiceID', $taxiServiceId)
            ->where('IsActive', true)
            ->with(['user'])
            ->get();

        // Here we would add logic to check if the driver is already assigned to another booking at the requested time
        // This would involve checking the TaxiBookings table
        // For now, we're just returning all active drivers

        return $drivers;
    }

    /**
     * Create a new driver
     *
     * @param array $data
     * @return \App\Models\Driver
     * @throws \Exception
     */
    public function createDriver(array $data): Driver
    {
        try {
            return DB::transaction(function () use ($data) {
                return Driver::create($data);
            });
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while creating driver: ' . $e->getMessage());
        }
    }

    /**
     * Update a driver
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Driver
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function updateDriver(int $id, array $data): Driver
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $driver = Driver::findOrFail($id);
                $driver->update($data);
                return $driver->fresh();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Driver not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while updating driver: ' . $e->getMessage());
        }
    }

    /**
     * Update driver rating
     *
     * @param int $id
     * @param float $rating
     * @return \App\Models\Driver
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function updateDriverRating(int $id, float $rating): Driver
    {
        try {
            return DB::transaction(function () use ($id, $rating) {
                $driver = Driver::findOrFail($id);
                $driver->Rating = $rating;
                $driver->save();
                return $driver->fresh();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Driver not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while updating driver rating: ' . $e->getMessage());
        }
    }

    /**
     * Delete a driver
     *
     * @param int $id
     * @return bool
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function deleteDriver(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $driver = Driver::findOrFail($id);
                return $driver->delete();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Driver not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while deleting driver: ' . $e->getMessage());
        }
    }
}
