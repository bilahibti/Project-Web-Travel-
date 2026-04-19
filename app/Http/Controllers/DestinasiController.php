<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destinasi;
use App\Helpers\ImageHelper;

class DestinasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinasi = Destinasi::orderBy('nama_destinasi', 'asc')->get(); 
        return view('backend.v_destinasi.index', [ 
            'judul' => 'Destinasi', 
            'index' => $destinasi 
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_destinasi.create', [ 
            'judul' => 'Destinasi', 
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request) 
    { 
        $validatedData = $request->validate([ 
            'nama_destinasi' => 'required|max:255',
            'negara' => 'required|max:255', 
            'deskripsi' => 'required',
            'lokasi' => 'required|max:255',
            'harga_tiket' => 'required|numeric|min:0', 
            'status' => 'required|in:Tersedia,Full Booked',  
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024',  
        ], $messages = [ 
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.', 
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.' 
        ]);  
 
        if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $directory = 'storage/img-destinasi/';
        ImageHelper::uploadAndResize($file, $directory, $originalFileName);
        $validatedData['foto'] = $originalFileName;
    }
        Destinasi::create($validatedData); 
        return redirect()->route('backend.destinasi.index')->with('success', 'Data berhasil tersimpan');
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
        $destinasi = Destinasi::find($id); 
        return view('backend.v_destinasi.edit', [ 
            'judul' => 'Destinasi', 
            'edit' => $destinasi 
        ]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ddd($request); 
        $destinasi = Destinasi::findOrFail($id); 
        $validatedData = $request->validate([ 
            'nama_destinasi' => 'required|max:255',
            'negara' => 'required|max:255', 
            'deskripsi' => 'required',
            'lokasi' => 'required|max:255',
            'harga_tiket' => 'required|numeric|min:0', 
            'status' => 'required|in:Tersedia,Full Booked',  
            'foto' => 'image|mimes:jpeg,jpg,png,gif|file|max:1024', 
        ],
        $messages = [ 
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png, atau gif.', 
            'foto.max' => 'Ukuran file gambar Maksimal adalah 1024 KB.' 
        ]); 
 
        // menggunakan ImageHelper 
        if ($request->file('foto')) { 
            //hapus gambar lama 
            if ($destinasi->foto) { 
                $oldImagePath = public_path('storage/img-destinasi/') . $destinasi->foto; 
                if (file_exists($oldImagePath)) { 
                    unlink($oldImagePath); 
                } 
            } 
            $file = $request->file('foto'); 
            $extension = $file->getClientOriginalExtension(); 
            $originalFileName = date('YmdHis') . '_' . uniqid() . '.' . $extension; 
            $directory = 'storage/img-destinasi/'; 
            // Simpan gambar dengan ukuran yang ditentukan 
            ImageHelper::uploadAndResize($file, $directory, $originalFileName, 385, 400); // null (jika tinggi otomatis) 
            // Simpan nama file asli di database 
            $validatedData['foto'] = $originalFileName; 
        } 
 
        $destinasi->update($validatedData); 
        return redirect()->route('backend.destinasi.index')->with('success', 'Data berhasil diperbaharui'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $destinasi = destinasi::findOrFail($id); 
        $destinasi ->delete(); 
        return redirect()->route('backend.destinasi.index')->with('success', 'Data berhasil dihapus'); 
    }
}
