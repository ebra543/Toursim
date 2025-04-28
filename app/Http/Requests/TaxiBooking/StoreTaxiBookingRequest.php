<?php

namespace App\Http\Requests\TaxiBooking;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaxiBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'BookingID' => 'required|exists:Bookings,BookingID',
            'TaxiServiceID' => 'required|exists:TaxiServices,TaxiServiceID',
            'VehicleTypeID' => 'required|exists:VehicleTypes,VehicleTypeID',
            'PickupAddress' => 'required_without:PickupLocationID|string',
            'DropoffAddress' => 'required_without:DropoffLocationID|string',
            'PickupLocationID' => 'required_without:PickupAddress|exists:Locations,LocationID',
            'DropoffLocationID' => 'required_without:DropoffAddress|exists:Locations,LocationID',
            'PickupDateTime' => 'required|date',
            'DriverID' => 'nullable|exists:Drivers,DriverID',
            'VehicleID' => 'nullable|exists:Vehicles,VehicleID',
            // For nested location data
            'pickup_location' => 'nullable|array',
            'pickup_location.Latitude' => 'required_with:pickup_location|numeric',
            'pickup_location.Longitude' => 'required_with:pickup_location|numeric',
            'pickup_location.Name' => 'nullable|string',
            'pickup_location.Address' => 'nullable|string',
            'pickup_location.City' => 'nullable|string',
            'pickup_location.State' => 'nullable|string',
            'pickup_location.Country' => 'nullable|string',
            'pickup_location.PostalCode' => 'nullable|string',
            'dropoff_location' => 'nullable|array',
            'dropoff_location.Latitude' => 'required_with:dropoff_location|numeric',
            'dropoff_location.Longitude' => 'required_with:dropoff_location|numeric',
            'dropoff_location.Name' => 'nullable|string',
            'dropoff_location.Address' => 'nullable|string',
            'dropoff_location.City' => 'nullable|string',
            'dropoff_location.State' => 'nullable|string',
            'dropoff_location.Country' => 'nullable|string',
            'dropoff_location.PostalCode' => 'nullable|string',
        ];
    }
}
