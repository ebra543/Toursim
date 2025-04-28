<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of restaurants.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // This is just a test controller
        return view('pages.restaurants.index', [
            'restaurants' => [
                ['id' => 1, 'name' => 'Fine Dining', 'description' => 'Elegant restaurant with gourmet cuisine', 'price' => '$$$$'],
                ['id' => 2, 'name' => 'Local Eatery', 'description' => 'Authentic local dishes', 'price' => '$$'],
                ['id' => 3, 'name' => 'Fast Food', 'description' => 'Quick and convenient meals', 'price' => '$'],
            ]
        ]);
    }
}
