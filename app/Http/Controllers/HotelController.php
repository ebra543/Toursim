<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * Display a listing of hotels.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // This is just a test controller
        return view('pages.hotels.index', [
            'hotels' => [
                ['id' => 1, 'name' => 'Grand Hotel', 'description' => 'Luxury 5-star hotel', 'price' => 200],
                ['id' => 2, 'name' => 'Budget Inn', 'description' => 'Affordable accommodation', 'price' => 80],
                ['id' => 3, 'name' => 'Seaside Resort', 'description' => 'Beautiful ocean views', 'price' => 150],
            ]
        ]);
    }
}
