<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelPackages;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Transportation;

class TravelPackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $travelpackages = TravelPackages::orderBy('updated_at', 'desc')->get(); 
        return view('backend.v_packages.index', [ 
            'judul' => 'Travel Packages', 
            'index' => $travelpackages
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $destination = Destination::orderBy('destination_name', 'asc')->get();
        $hotel = Hotel::orderBy('hotel_name', 'asc')->get(); 
        $transportation = Transportation::orderBy('transportation_name', 'asc')->get();
        return view('backend.v_packages.create', [ 
            'destination' => $destination,
            'hotel' => $hotel,
            'transportation' => $transportation
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([ 
            'destination_id' => 'required|exists:destination,id',
            'hotel_id' => 'required|exists:hotel,id',
            'transportation_id' => 'required|exists:transportation,id',
            'packages_name' => 'required|string|max:255',
            'description' => 'required',
            'price_packages' => 'required|numeric',
            'package_type' => 'required|in:Domestic,International',
            'include' => 'required',
            'exclude' => 'required',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:Available,Full Booked',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png',

        ],
        $messages = [ 
            'foto.image' => 'The image must be a file of type: jpeg, jpg, png, or gif.',
            'foto.max' => 'The maximum image size allowed is 1024 KB.'
        ]);

        TravelPackages::create($request->all());
        return redirect()->route('backend.travel-packages.index')->with('success', 'Data successfully saved'); 
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
        $travelPackages = TravelPackage::findOrFail($id);

        $destinations = Destination::all();
        $hotels = Hotel::all();
        $transportations = Transportation::all();

        return view('travel_packages.edit', compact(
            'travelPackage',
            'destinations',
            'hotels',
            'transportations'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ddd($request); 
        $travelpackages = TravelPackages::findOrFail($id); 
        $validatedData = $request->validate([
            'destination_id' => 'required|exists:destination,id',
            'hotel_id' => 'required|exists:hotel,id',
            'transportation_id' => 'required|exists:transportation,id',
            'packages_name' => 'required|string|max:255',
            'description' => 'required',
            'price_packages' => 'required|numeric',
            'package_type' => 'required|in:Domestic,International',
            'include' => 'required',
            'exclude' => 'required',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:Available,Full Booked',
        ],
        $messages = [ 
            'foto.image' => 'The image must be a file of type: jpeg, jpg, png, or gif.',
            'foto.max' => 'The maximum image size allowed is 1024 KB.'
        ]);

        $travelPackages->update($validatedData); 
        return redirect()->route('backend.travel-packages.index')->with('success', 'Data successfully updated'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $travelpackages = TravelPackages::findOrFail($id); 
        $travelpackages ->delete(); 
        return redirect()->route('backend.travel-packages.index')->with('success', 'Data successfully deleted'); 
    }

    public function frontendIndex()
    {
        $packages = TravelPackages::with(['destination', 'hotel', 'transportation'])
            ->where('status', 'Available')
            ->paginate(12);

        return view('frontend.v_tours.tours', compact('packages'));
    }

    public function frontendShow(string $id)
    {
        $package = TravelPackages::with(['destination', 'hotel', 'transportation'])
            ->findOrFail($id);

        return view('frontend.v_tours.show', compact('package'));
    }
}
