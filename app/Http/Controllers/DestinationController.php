<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Helpers\ImageHelper;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destination = Destination::orderBy('destination_name', 'asc')->get(); 
        return view('backend.v_destination.index', [ 
            'judul' => 'Destination', 
            'index' => $destination 
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_destination.create', [ 
            'judul' => 'Destination', 
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request) 
    { 
        $validatedData = $request->validate([ 
            'destination_name' => 'required|max:255',
            'country' => 'required|max:50', 
            'city' => 'required|max:50',
            'description' => 'required',
            'destination_type' => 'required|in:Domestic,International',
            'quota' => 'required|integer|min:1', 
            'status' => 'required|in:Available,Full Booked',  
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',  
        ], $messages = [ 
            'foto.image' => 'The image must be a file of type: jpeg, jpg, png, or gif.',
            'foto.max' => 'The maximum image size allowed is 1024 KB.' 
        ]);  
 
        if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $directory = 'storage/img-destination/';
        ImageHelper::uploadAndResize($file, $directory, $originalFileName);
        $validatedData['foto'] = $originalFileName;
    }
        Destination::create($validatedData); 
        return redirect()->route('backend.destination.index')->with('success', 'Data saved successfully');
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
        $destination = Destination::find($id); 
        return view('backend.v_destination.edit', [ 
            'judul' => 'Destination', 
            'edit' => $destination 
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ddd($request); 
        $destination = Destination::findOrFail($id); 
        $validatedData = $request->validate([ 
            'destination_name' => 'required|max:255',
            'country' => 'required|max:50', 
            'city' => 'required|max:50',
            'description' => 'required',
            'destination_type' => 'required|in:Domestic,International',
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
            if ($destination->foto) { 
                $oldImagePath = public_path('storage/img-destination/') . $destination->foto; 
                if (file_exists($oldImagePath)) { 
                    unlink($oldImagePath); 
                } 
            } 
            $file = $request->file('foto'); 
            $extension = $file->getClientOriginalExtension(); 
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
            $directory = 'storage/img-destination/'; 
            // Simpan gambar dengan ukuran yang ditentukan 
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400); // null (jika tinggi otomatis) 
            // Simpan nama file asli di database 
            $validatedData['foto'] = $originalFileName; 
        } 
 
        $destination->update($validatedData); 
        return redirect()->route('backend.destination.index')->with('success', 'Data successfully updated'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destination = Destination::findOrFail($id); 
        $destination ->delete(); 
        return redirect()->route('backend.destination.index')->with('success', 'Data successfully deleted'); 
    }

    public function frontendIndex()
    {
        $destinations = Destination::where('status', 'Available')
            ->orderBy('destination_name')
            ->paginate(12);

        return view('frontend.v_destination.destination', compact('destinations'));
    }

    public function frontendShow(string $id)
    {
        $destination = Destination::findOrFail($id);
        $packages = TravelPackages::where('destination_id', $id)
            ->where('status', 'Available')
            ->get();
        $hotels = Hotel::where('destination_id', $id)
            ->where('status', 'Available')
            ->get();

        return view('frontend.v_destination.show', compact('destination', 'packages', 'hotels'));
    }
}
