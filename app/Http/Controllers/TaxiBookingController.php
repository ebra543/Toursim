<?php

namespace App\Http\Controllers;

use App\Models\TaxiBooking;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Services\GeoapifyService;
use App\Services\TaxiBooking\TaxiBookingService;
use App\Http\Requests\TaxiBooking\StoreTaxiBookingRequest;
use App\Http\Requests\TaxiBooking\UpdateTaxiBookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaxiBookingController extends Controller
{
    protected $geoapify;
    protected $taxiBookingService;

    public function __construct(GeoapifyService $geoapify, TaxiBookingService $taxiBookingService)
    {
        $this->geoapify = $geoapify;
        $this->taxiBookingService = $taxiBookingService;
    }

    /**
     * Display a listing of the taxi bookings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $taxiBookings = $this->taxiBookingService->getAllTaxiBookings();
            return response()->json(['data' => $taxiBookings]);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to retrieve taxi bookings: ' . $e->getMessage()]], 500);
        }
    }

    /**
     * Store a newly created taxi booking in storage.
     *
     * @param  \App\Http\Requests\TaxiBooking\StoreTaxiBookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaxiBookingRequest $request)
    {
        try {
            $data = $request->validated();

            // If addresses are provided but not coordinates, geocode them
            if (isset($data['PickupAddress']) && !isset($data['pickup_location'])) {
                $pickupGeocode = $this->geoapify->geocodeAddress($data['PickupAddress']);
                if (!$pickupGeocode) {
                    return response()->json(['error' => 'Failed to geocode pickup address'], 422);
                }

                $data['pickup_location'] = [
                    'Latitude' => $pickupGeocode['lat'],
                    'Longitude' => $pickupGeocode['lon'],
                    'Address' => $data['PickupAddress'],
                    'City' => $pickupGeocode['city'] ?? null,
                    'State' => $pickupGeocode['state'] ?? null,
                    'Country' => $pickupGeocode['country'] ?? null,
                    'PostalCode' => $pickupGeocode['postcode'] ?? null,
                ];
            }

            if (isset($data['DropoffAddress']) && !isset($data['dropoff_location'])) {
                $dropoffGeocode = $this->geoapify->geocodeAddress($data['DropoffAddress']);
                if (!$dropoffGeocode) {
                    return response()->json(['error' => 'Failed to geocode dropoff address'], 422);
                }

                $data['dropoff_location'] = [
                    'Latitude' => $dropoffGeocode['lat'],
                    'Longitude' => $dropoffGeocode['lon'],
                    'Address' => $data['DropoffAddress'],
                    'City' => $dropoffGeocode['city'] ?? null,
                    'State' => $dropoffGeocode['state'] ?? null,
                    'Country' => $dropoffGeocode['country'] ?? null,
                    'PostalCode' => $dropoffGeocode['postcode'] ?? null,
                ];
            }

            // Calculate route and distance if we have both locations
            if (isset($data['pickup_location']) && isset($data['dropoff_location'])) {
                $route = $this->geoapify->getRoute(
                    $data['pickup_location']['Latitude'],
                    $data['pickup_location']['Longitude'],
                    $data['dropoff_location']['Latitude'],
                    $data['dropoff_location']['Longitude'],
                    'drive'
                );

                if (!$route || !isset($route['distance'])) {
                    return response()->json(['error' => 'Failed to calculate route'], 422);
                }

                $data['EstimatedDistance'] = $route['distance'] / 1000; // Convert to kilometers
            }

            $taxiBooking = $this->taxiBookingService->createTaxiBooking($data);

            return response()->json([
                'data' => $taxiBooking,
                'message' => 'Taxi booking created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to create taxi booking: ' . $e->getMessage()]], 500);
        }
    }

    /**
     * Display the specified taxi booking.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $taxiBooking = $this->taxiBookingService->getTaxiBookingById($id);
            return response()->json(['data' => $taxiBooking]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => ['Taxi booking not found']], 404);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to retrieve taxi booking: ' . $e->getMessage()]], 500);
        }
    }

    /**
     * Update the specified taxi booking in storage.
     *
     * @param  \App\Http\Requests\TaxiBooking\UpdateTaxiBookingRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaxiBookingRequest $request, $id)
    {
        try {
            $data = $request->validated();

            // If addresses are provided but not coordinates, geocode them
            if (isset($data['PickupAddress']) && !isset($data['pickup_location'])) {
                $pickupGeocode = $this->geoapify->geocodeAddress($data['PickupAddress']);
                if (!$pickupGeocode) {
                    return response()->json(['error' => 'Failed to geocode pickup address'], 422);
                }

                $data['pickup_location'] = [
                    'Latitude' => $pickupGeocode['lat'],
                    'Longitude' => $pickupGeocode['lon'],
                    'Address' => $data['PickupAddress'],
                    'City' => $pickupGeocode['city'] ?? null,
                    'State' => $pickupGeocode['state'] ?? null,
                    'Country' => $pickupGeocode['country'] ?? null,
                    'PostalCode' => $pickupGeocode['postcode'] ?? null,
                ];
            }

            if (isset($data['DropoffAddress']) && !isset($data['dropoff_location'])) {
                $dropoffGeocode = $this->geoapify->geocodeAddress($data['DropoffAddress']);
                if (!$dropoffGeocode) {
                    return response()->json(['error' => 'Failed to geocode dropoff address'], 422);
                }

                $data['dropoff_location'] = [
                    'Latitude' => $dropoffGeocode['lat'],
                    'Longitude' => $dropoffGeocode['lon'],
                    'Address' => $data['DropoffAddress'],
                    'City' => $dropoffGeocode['city'] ?? null,
                    'State' => $dropoffGeocode['state'] ?? null,
                    'Country' => $dropoffGeocode['country'] ?? null,
                    'PostalCode' => $dropoffGeocode['postcode'] ?? null,
                ];
            }

            // Calculate route and distance if we have both locations
            if (isset($data['pickup_location']) && isset($data['dropoff_location'])) {
                $route = $this->geoapify->getRoute(
                    $data['pickup_location']['Latitude'],
                    $data['pickup_location']['Longitude'],
                    $data['dropoff_location']['Latitude'],
                    $data['dropoff_location']['Longitude'],
                    'drive'
                );

                if (!$route || !isset($route['distance'])) {
                    return response()->json(['error' => 'Failed to calculate route'], 422);
                }

                $data['EstimatedDistance'] = $route['distance'] / 1000; // Convert to kilometers
            }

            $taxiBooking = $this->taxiBookingService->updateTaxiBooking($id, $data);

            return response()->json([
                'data' => $taxiBooking,
                'message' => 'Taxi booking updated successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => ['Taxi booking not found']], 404);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to update taxi booking: ' . $e->getMessage()]], 500);
        }
    }

    /**
     * Remove the specified taxi booking from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->taxiBookingService->deleteTaxiBooking($id);
            return response()->json(['message' => 'Taxi booking deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => ['Taxi booking not found']], 404);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Failed to delete taxi booking: ' . $e->getMessage()]], 500);
        }
    }

    /**
     * Calculate fare for a taxi route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculateFare(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'VehicleTypeID' => 'required|exists:VehicleTypes,VehicleTypeID',
            'PickupAddress' => 'required|string',
            'DropoffAddress' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Get vehicle type details for pricing
            $vehicleType = DB::table('VehicleTypes')->where('VehicleTypeID', $request->VehicleTypeID)->first();

            if (!$vehicleType) {
                return response()->json(['error' => 'Vehicle type not found'], 404);
            }

            // Use Geoapify to geocode the pickup and dropoff addresses
            $pickupGeocode = $this->geoapify->geocodeAddress($request->PickupAddress);
            $dropoffGeocode = $this->geoapify->geocodeAddress($request->DropoffAddress);

            if (!$pickupGeocode || !$dropoffGeocode) {
                return response()->json(['error' => 'Failed to geocode addresses'], 422);
            }

            // Calculate route and distance
            $route = $this->geoapify->getRoute(
                $pickupGeocode['lat'],
                $pickupGeocode['lon'],
                $dropoffGeocode['lat'],
                $dropoffGeocode['lon'],
                'drive'
            );

            if (!$route || !isset($route['distance'])) {
                return response()->json(['error' => 'Failed to calculate route'], 422);
            }

            // Calculate fare based on distance and vehicle type pricing
            $distanceInKm = $route['distance'] / 1000;
            $fare = $vehicleType->BasePrice + ($distanceInKm * $vehicleType->PricePerKm);

            // Round to 2 decimal places
            $fare = round($fare, 2);

            return response()->json([
                'data' => [
                    'distance' => $distanceInKm,
                    'duration' => isset($route['time']) ? round($route['time'] / 60, 0) : null, // Convert to minutes
                    'fare' => $fare,
                    'currency' => 'USD',
                    'vehicle_type' => $vehicleType->TypeName,
                    'route' => $route
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while calculating fare: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get taxi bookings by user.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function getBookingsByUser($userId)
    {
        try {
            $taxiBookings = TaxiBooking::whereHas('booking', function($query) use ($userId) {
                    $query->where('UserID', $userId);
                })
                ->with([
                    'booking',
                    'taxiService',
                    'vehicleType',
                    'pickupLocation',
                    'dropoffLocation',
                    'driver',
                    'vehicle'
                ])
                ->get();

            if ($taxiBookings === null) {
                throw new \Exception('Taxi bookings not found');
            }

            return response()->json(['data' => $taxiBookings]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Assign driver and vehicle to a booking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignDriverAndVehicle(Request $request, $id)
    {
        $taxiBooking = TaxiBooking::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'DriverID' => 'required|exists:Drivers,DriverID',
            'VehicleID' => 'required|exists:Vehicles,VehicleID',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Verify driver belongs to the taxi service
            $driver = Driver::where('DriverID', $request->DriverID)
                ->where('TaxiServiceID', $taxiBooking->TaxiServiceID)
                ->first();

            if (!$driver) {
                throw new \Exception('Driver does not belong to the taxi service');
            }

            // Verify vehicle belongs to the taxi service and matches the vehicle type
            $vehicle = Vehicle::where('VehicleID', $request->VehicleID)
                ->where('TaxiServiceID', $taxiBooking->TaxiServiceID)
                ->where('VehicleTypeID', $taxiBooking->VehicleTypeID)
                ->first();

            if (!$vehicle) {
                throw new \Exception('Vehicle does not match requirements');
            }

            // Assign driver and vehicle
            $taxiBooking->DriverID = $request->DriverID;
            $taxiBooking->VehicleID = $request->VehicleID;
            $taxiBooking->save();

            return response()->json([
                'data' => $taxiBooking->load([
                    'booking',
                    'taxiService',
                    'vehicleType',
                    'pickupLocation',
                    'dropoffLocation',
                    'driver',
                    'vehicle'
                ]),
                'message' => 'Driver and vehicle assigned successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
