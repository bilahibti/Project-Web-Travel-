<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportation;
use App\Models\Destination;

class TransportationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transportation = Transportation::orderBy('transportation_name', 'asc')->get(); 
        return view('backend.v_transportation.index', [ 
            'judul' => 'Transportation', 
            'index' => $transportation 
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_transportation.create', [ 
            'judul' => 'Transportation', 
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([ 
            'transportation_name' => 'required|string|max:255',
            'transportation_type' => 'required|string|max:255',
            'departure_destination_id' => 'required|exists:destination,id',
            'arrival_destination_id' => 'required|exists:destination,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price_per_person' => 'required|numeric',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:Available,Full Booked',    
        ]);  

        Transportation::create($validatedData); 
        return redirect()->route('backend.transportation.index')->with('success', 'Data successfully saved');
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
        $transportation = Transportation::find($id); 
        return view('backend.v_transportation.edit', [ 
            'judul' => 'Transportation', 
            'edit' => $transportation 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ddd($request); 
        $transportation = Transportation::findOrFail($id); 
        $validatedData = $request->validate([
            'transportation_name' => 'required|string|max:255',
            'transportation_type' => 'required|string|max:255',
            'departure_destination_id' => 'required|exists:destination,id',
            'arrival_destination_id' => 'required|exists:destination,id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price_per_person' => 'required|numeric',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:Available,Full Booked',
        ]);

        $transportation->update($validatedData); 
        return redirect()->route('backend.transportation.index')->with('success', 'Data successfully updated'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transportation = Transportation::findOrFail($id); 
        $transportation ->delete(); 
        return redirect()->route('backend.transportation.index')->with('success', 'Data successfully deleted'); 
    }
}
