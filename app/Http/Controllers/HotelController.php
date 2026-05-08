<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Destination;
use App\Helpers\ImageHelper;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotel = Hotel::orderBy('hotel_name', 'asc')->get(); 
        return view('backend.v_hotel.index', [ 
            'judul' => 'Hotel', 
            'index' => $hotel
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_hotel.create', [ 
            'judul' => 'Hotel', 
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([ 
            'destination_id' => 'required|exists:destination,id',
            'hotel_name' => 'required|string|max:255',
            'address' => 'required',
            'description' => 'required',
            'star_rating' => 'required|integer|min:1|max:5',
            'price_per_night' => 'required|numeric',
            'facilities' => 'required',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:Available,Full Booked',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png',
        ], $messages = [ 
            'foto.image' => 'The image must be a file of type: jpeg, jpg, png, or gif.',
            'foto.max' => 'The maximum image size allowed is 1024 KB.' 
        ]);  
 
        if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $directory = 'storage/img-hotel/';
        ImageHelper::uploadAndResize($file, $directory, $originalFileName);
        $validatedData['foto'] = $originalFileName;
    }
        Hotel::create($validatedData); 
        return redirect()->route('backend.hotel.index')->with('success', 'Data successfully saved');
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
        $hotel = Hotel::find($id); 
        return view('backend.v_hotel.edit', [ 
            'judul' => 'Hotel', 
            'edit' => $hotel 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         //ddd($request); 
        $hotel = Hotel::findOrFail($id); 
        $validatedData = $request->validate([ 
            'hotel_name' => 'required|max:255',
            'address' => 'required',
            'description' => 'required',
            'star_rating' => 'required|integer|min:1|max:5',
            'price_per_night' => 'required|numeric',
            'facilities' => 'required',
            'quota' => 'required|integer|min:1',
            'status' => 'required|in:Available,Full Booked',
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',  
        ], 
        $messages = [ 
            'foto.image' => 'The image must be a file of type: jpeg, jpg, png, or gif.', 
            'foto.max' => 'The maximum image size allowed is 1024 KB.' 
        ]); 
 
        // menggunakan ImageHelper 
        if ($request->file('foto')) { 
            //hapus gambar lama 
            if ($hotel->foto) { 
                $oldImagePath = public_path('storage/img-hotel/') . $hotel->foto; 
                if (file_exists($oldImagePath)) { 
                    unlink($oldImagePath); 
                } 
            } 
            $file = $request->file('foto'); 
            $extension = $file->getClientOriginalExtension(); 
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
            $directory = 'storage/img-hotel/'; 
            // Simpan gambar dengan ukuran yang ditentukan 
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400); // null (jika tinggi otomatis) 
            // Simpan nama file asli di database 
            $validatedData['foto'] = $originalFileName; 
        } 
 
        $hotel->update($validatedData); 
        return redirect()->route('backend.hotel.index')->with('success', 'Data successfully updated'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hotel = Hotel::findOrFail($id); 
        $hotel ->delete(); 
        return redirect()->route('backend.hotel.index')->with('success', 'Data successfully deleted'); 
    }

}
