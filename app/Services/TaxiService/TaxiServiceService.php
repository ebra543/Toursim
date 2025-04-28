<?php

namespace App\Services\TaxiService;

use App\Models\TaxiService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaxiServiceService
{
    /**
     * Get all taxi services
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTaxiServices(): Collection
    {
        return TaxiService::with('location')->get();
    }

    /**
     * Get active taxi services
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveTaxiServices(): Collection
    {
        return TaxiService::where('IsActive', true)->with('location')->get();
    }

    /**
     * Get taxi services by location
     *
     * @param int $locationId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTaxiServicesByLocation(int $locationId): Collection
    {
        return TaxiService::where('LocationID', $locationId)
            ->where('IsActive', true)
            ->with('location')
            ->get();
    }

    /**
     * Get a taxi service by ID
     *
     * @param int $id
     * @return \App\Models\TaxiService
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getTaxiServiceById(int $id): TaxiService
    {
        return TaxiService::with(['location', 'vehicles', 'drivers', 'vehicleTypes'])->findOrFail($id);
    }

    /**
     * Create a new taxi service
     *
     * @param array $data
     * @return \App\Models\TaxiService
     * @throws \Exception
     */
    public function createTaxiService(array $data): TaxiService
    {
        try {
            return DB::transaction(function () use ($data) {
                return TaxiService::create($data);
            });
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while creating taxi service: ' . $e->getMessage());
        }
    }

    /**
     * Update a taxi service
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\TaxiService
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function updateTaxiService(int $id, array $data): TaxiService
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $taxiService = TaxiService::findOrFail($id);
                $taxiService->update($data);
                return $taxiService->fresh();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Taxi service not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while updating taxi service: ' . $e->getMessage());
        }
    }

    /**
     * Delete a taxi service
     *
     * @param int $id
     * @return bool
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function deleteTaxiService(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $taxiService = TaxiService::findOrFail($id);
                return $taxiService->delete();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Taxi service not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while deleting taxi service: ' . $e->getMessage());
        }
    }
}
