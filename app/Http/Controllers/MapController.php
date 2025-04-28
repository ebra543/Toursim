<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeoapifyService;

class MapController extends Controller
{
    protected $geoapify;
    
    public function __construct(GeoapifyService $geoapify)
    {
        $this->geoapify = $geoapify;
    }
    
    /**
     * Show the address selection map
     */
    public function selectAddress()
    {
        $mapTilesKey = config('app.geoapify.map_tiles');
        $geocodingKey = config('app.geoapify.geocoding');
        
        return view('maps.select-address', compact('mapTilesKey', 'geocodingKey'));
    }
    
    /**
     * Show the taxi route tracking map
     */
    public function taxiRoute()
    {
        $mapTilesKey = config('app.geoapify.map_tiles');
        $routingKey = config('app.geoapify.routing');
        $geocodingKey = config('app.geoapify.geocoding');
        
        return view('maps.taxi-route', compact('mapTilesKey', 'routingKey', 'geocodingKey'));
    }
    
    /**
     * Search for places
     */
    public function searchPlaces(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|string',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'radius' => 'nullable|numeric'
        ]);
        
        $radius = $validated['radius'] ?? 1000;
        
        $places = $this->geoapify->searchPlaces(
            $validated['categories'],
            $validated['lat'],
            $validated['lon'],
            $radius
        );
        
        return response()->json($places);
    }
    
    /**
     * Get route between two points
     */
    public function getRoute(Request $request)
    {
        $validated = $request->validate([
            'from_lat' => 'required|numeric',
            'from_lon' => 'required|numeric',
            'to_lat' => 'required|numeric',
            'to_lon' => 'required|numeric',
            'mode' => 'nullable|string'
        ]);
        
        $mode = $validated['mode'] ?? 'drive';
        
        $route = $this->geoapify->getRoute(
            $validated['from_lat'],
            $validated['from_lon'],
            $validated['to_lat'],
            $validated['to_lon'],
            $mode
        );
        
        return response()->json($route);
    }
    
    /**
     * Geocode an address
     */
    public function geocodeAddress(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string'
        ]);
        
        $result = $this->geoapify->geocodeAddress($validated['address']);
        
        return response()->json($result);
    }
    
    /**
     * Reverse geocode coordinates
     */
    public function reverseGeocode(Request $request)
    {
        $validated = $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
        ]);
        
        $result = $this->geoapify->reverseGeocode($validated['lat'], $validated['lon']);
        
        return response()->json($result);
    }
}