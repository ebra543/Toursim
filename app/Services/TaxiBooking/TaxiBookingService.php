<?php

namespace App\Services\TaxiBooking;

use App\Models\TaxiBooking;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaxiBookingService
{
    /**
     * Get all taxi bookings
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllTaxiBookings(): Collection
    {
        return TaxiBooking::with([
            'booking',
            'taxiService',
            'vehicleType',
            'pickupLocation',
            'dropoffLocation',
            'driver',
            'vehicle'
        ])->get();
    }

    /**
     * Get a taxi booking by ID
     *
     * @param int $id
     * @return \App\Models\TaxiBooking
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getTaxiBookingById(int $id): TaxiBooking
    {
        return TaxiBooking::with([
            'booking',
            'taxiService',
            'vehicleType',
            'pickupLocation',
            'dropoffLocation',
            'driver',
            'vehicle'
        ])->findOrFail($id);
    }

    /**
     * Get taxi bookings by booking ID
     *
     * @param int $bookingId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTaxiBookingsByBookingId(int $bookingId): Collection
    {
        return TaxiBooking::where('BookingID', $bookingId)
            ->with([
                'taxiService',
                'vehicleType',
                'pickupLocation',
                'dropoffLocation',
                'driver',
                'vehicle'
            ])
            ->get();
    }

    /**
     * Get taxi bookings by taxi service ID
     *
     * @param int $taxiServiceId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTaxiBookingsByTaxiServiceId(int $taxiServiceId): Collection
    {
        return TaxiBooking::where('TaxiServiceID', $taxiServiceId)
            ->with([
                'booking',
                'vehicleType',
                'pickupLocation',
                'dropoffLocation',
                'driver',
                'vehicle'
            ])
            ->get();
    }

    /**
     * Get taxi bookings by driver ID
     *
     * @param int $driverId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTaxiBookingsByDriverId(int $driverId): Collection
    {
        return TaxiBooking::where('DriverID', $driverId)
            ->with([
                'booking',
                'taxiService',
                'vehicleType',
                'pickupLocation',
                'dropoffLocation',
                'vehicle'
            ])
            ->get();
    }

    /**
     * Create a new taxi booking
     *
     * @param array $data
     * @return \App\Models\TaxiBooking
     * @throws \Exception
     */
    public function createTaxiBooking(array $data): TaxiBooking
    {
        try {
            return DB::transaction(function () use ($data) {
                // Create or get pickup location
                if (isset($data['pickup_location']) && !isset($data['PickupLocationID'])) {
                    $pickupLocation = Location::firstOrCreate(
                        ['Latitude' => $data['pickup_location']['Latitude'], 'Longitude' => $data['pickup_location']['Longitude']],
                        [
                            'Name' => $data['pickup_location']['Name'] ?? 'Pickup Location',
                            'Address' => $data['pickup_location']['Address'] ?? '',
                            'City' => $data['pickup_location']['City'] ?? '',
                            'State' => $data['pickup_location']['State'] ?? '',
                            'Country' => $data['pickup_location']['Country'] ?? '',
                            'PostalCode' => $data['pickup_location']['PostalCode'] ?? ''
                        ]
                    );
                    $data['PickupLocationID'] = $pickupLocation->LocationID;
                }

                // Create or get dropoff location
                if (isset($data['dropoff_location']) && !isset($data['DropoffLocationID'])) {
                    $dropoffLocation = Location::firstOrCreate(
                        ['Latitude' => $data['dropoff_location']['Latitude'], 'Longitude' => $data['dropoff_location']['Longitude']],
                        [
                            'Name' => $data['dropoff_location']['Name'] ?? 'Dropoff Location',
                            'Address' => $data['dropoff_location']['Address'] ?? '',
                            'City' => $data['dropoff_location']['City'] ?? '',
                            'State' => $data['dropoff_location']['State'] ?? '',
                            'Country' => $data['dropoff_location']['Country'] ?? '',
                            'PostalCode' => $data['dropoff_location']['PostalCode'] ?? ''
                        ]
                    );
                    $data['DropoffLocationID'] = $dropoffLocation->LocationID;
                }

                // Remove the location data from the array as it's not part of the TaxiBooking model
                unset($data['pickup_location'], $data['dropoff_location']);

                return TaxiBooking::create($data);
            });
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while creating taxi booking: ' . $e->getMessage());
        }
    }

    /**
     * Update a taxi booking
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\TaxiBooking
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function updateTaxiBooking(int $id, array $data): TaxiBooking
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $taxiBooking = TaxiBooking::findOrFail($id);

                // Handle location updates if provided
                if (isset($data['pickup_location']) && !isset($data['PickupLocationID'])) {
                    $pickupLocation = Location::firstOrCreate(
                        ['Latitude' => $data['pickup_location']['Latitude'], 'Longitude' => $data['pickup_location']['Longitude']],
                        [
                            'Name' => $data['pickup_location']['Name'] ?? 'Pickup Location',
                            'Address' => $data['pickup_location']['Address'] ?? '',
                            'City' => $data['pickup_location']['City'] ?? '',
                            'State' => $data['pickup_location']['State'] ?? '',
                            'Country' => $data['pickup_location']['Country'] ?? '',
                            'PostalCode' => $data['pickup_location']['PostalCode'] ?? ''
                        ]
                    );
                    $data['PickupLocationID'] = $pickupLocation->LocationID;
                }

                if (isset($data['dropoff_location']) && !isset($data['DropoffLocationID'])) {
                    $dropoffLocation = Location::firstOrCreate(
                        ['Latitude' => $data['dropoff_location']['Latitude'], 'Longitude' => $data['dropoff_location']['Longitude']],
                        [
                            'Name' => $data['dropoff_location']['Name'] ?? 'Dropoff Location',
                            'Address' => $data['dropoff_location']['Address'] ?? '',
                            'City' => $data['dropoff_location']['City'] ?? '',
                            'State' => $data['dropoff_location']['State'] ?? '',
                            'Country' => $data['dropoff_location']['Country'] ?? '',
                            'PostalCode' => $data['dropoff_location']['PostalCode'] ?? ''
                        ]
                    );
                    $data['DropoffLocationID'] = $dropoffLocation->LocationID;
                }

                // Remove the location data from the array
                unset($data['pickup_location'], $data['dropoff_location']);

                $taxiBooking->update($data);
                return $taxiBooking->fresh();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Taxi booking not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while updating taxi booking: ' . $e->getMessage());
        }
    }

    /**
     * Assign a driver to a taxi booking
     *
     * @param int $id
     * @param int $driverId
     * @return \App\Models\TaxiBooking
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function assignDriver(int $id, int $driverId): TaxiBooking
    {
        try {
            return DB::transaction(function () use ($id, $driverId) {
                $taxiBooking = TaxiBooking::findOrFail($id);
                $taxiBooking->DriverID = $driverId;
                $taxiBooking->save();
                return $taxiBooking->fresh();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Taxi booking not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while assigning driver: ' . $e->getMessage());
        }
    }

    /**
     * Assign a vehicle to a taxi booking
     *
     * @param int $id
     * @param int $vehicleId
     * @return \App\Models\TaxiBooking
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function assignVehicle(int $id, int $vehicleId): TaxiBooking
    {
        try {
            return DB::transaction(function () use ($id, $vehicleId) {
                $taxiBooking = TaxiBooking::findOrFail($id);
                $taxiBooking->VehicleID = $vehicleId;
                $taxiBooking->save();
                return $taxiBooking->fresh();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Taxi booking not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while assigning vehicle: ' . $e->getMessage());
        }
    }

    /**
     * Delete a taxi booking
     *
     * @param int $id
     * @return bool
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Exception
     */
    public function deleteTaxiBooking(int $id): bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $taxiBooking = TaxiBooking::findOrFail($id);
                return $taxiBooking->delete();
            });
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Taxi booking not found');
        } catch (\Exception $e) {
            throw new \Exception('Error occurred while deleting taxi booking: ' . $e->getMessage());
        }
    }
}
