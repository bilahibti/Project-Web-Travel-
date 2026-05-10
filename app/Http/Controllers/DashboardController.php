<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\TravelPackage as Paket;
use App\Models\Hotel;
use App\Models\Transportation;

class DashboardController extends Controller
{
    public function dashboardBackend() 
    { 
        $travelpackages = Paket::all();
        $hotel = Hotel::all();
        $transportatiom = Transportation::all();
        $destination = Destination::all();
        
        return view('backend.v_dashboard.index', compact(
            'travelpackages',
             'hotel', 
             'transportation', 
             'destination'
        ));
    } 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destination = Destination::where('status', 'Available')->orderBy('updated_at', 'desc')->paginate(6); 
        return view('frontend.v_dashboard.index', [ 
            'judul' => 'Halan Beranda', 
            'destination' => $destination, 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
