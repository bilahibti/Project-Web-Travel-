<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportasi;

class TransportasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transportasi = Transportasi::orderBy('nama_transportasi', 'asc')->get(); 
        return view('backend.v_transportasi.index', [ 
            'judul' => 'Transportasi', 
            'index' => $transportasi 
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_transportasi.create', [ 
            'judul' => 'Transportasi', 
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([ 
            'jenis_transportasi' => 'required|max:255',
            'nama_transportasi' => 'required|max:255',
            'kota_keberangkatan' => 'required|max:255', 
            'kota_tujuan' => 'required|max:255', 
            'waktu_berangkat' => 'required|date',
            'waktu_tiba' => 'required|date|after:waktu_berangkat',
            'harga' => 'required|numeric|min:0', 
            'status' => 'required|in:Tersedia,Full Booked',    
        ]);  

        Transportasi::create($validatedData); 
        return redirect()->route('backend.transportasi.index')->with('success', 'Data berhasil tersimpan');
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
        $transportasi = Transportasi::find($id); 
        return view('backend.v_transportasi.edit', [ 
            'judul' => 'Transportasi', 
            'edit' => $transportasi 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ddd($request); 
        $transportasi = Transportasi::findOrFail($id); 
        $validatedData = $request->validate([
            'jenis_transportasi' => 'required|max:255',
            'nama_transportasi' => 'required|max:255',
            'kota_keberangkatan' => 'required|max:255', 
            'kota_tujuan' => 'required|max:255', 
            'waktu_berangkat' => 'required|date',
            'waktu_tiba' => 'required|date|after:waktu_berangkat',
            'harga' => 'required|numeric|min:0', 
            'status' => 'required|in:Tersedia,Full Booked', 
        ]);

        $transportasi->update($validatedData); 
        return redirect()->route('backend.transportasi.index')->with('success', 'Data berhasil diperbaharui'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transportasi = transportasi::findOrFail($id); 
        $transportasi ->delete(); 
        return redirect()->route('backend.transportasi.index')->with('success', 'Data berhasil dihapus'); 
    }
}
