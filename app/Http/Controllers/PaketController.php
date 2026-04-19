<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Models\Destinasi;
use App\Models\Hotel;
use App\Models\Transportasi;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paket = Paket::orderBy('updated_at', 'desc')->get(); 
        return view('backend.v_paket.index', [ 
            'judul' => 'Paket', 
            'index' => $paket
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $destinasi = Destinasi::orderBy('nama_destinasi', 'asc')->get();
        $hotel = Hotel::orderBy('nama_hotel', 'asc')->get(); 
        $transportasi = Transportasi::orderBy('nama_transportasi', 'asc')->get();
        return view('backend.v_paket.create', [ 
            'judul' => 'Paket', 
            'destinasi' => $destinasi,
            'hotel' => $hotel,
            'transportasi' => $transportasi
        ]); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([ 
            'destinasi_id' => 'required',
            'hotel_id' => 'required',
            'transportasi_id' => 'required', 
            'nama_paket' => 'required|max:255|unique:paket',  
            'harga' => 'required', 
            'status' => 'required|in:Tersedia,Full Booked',
        ]);

        Paket::create($request->all());
        return redirect()->route('backend.paket.index')->with('success', 'Data berhasil tersimpan'); 
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
        $destinasi = Destinasi::orderBy('nama_destinasi', 'asc')->get();
        $hotel = Hotel::orderBy('nama_hotel', 'asc')->get(); 
        $transportasi = Transportasi::orderBy('nama_transportasi', 'asc')->get();
        $paket = Paket::find($id); 
        return view('backend.v_paket.edit', [ 
            'judul' => 'Paket', 
            'destinasi' => $destinasi,
            'hotel' => $hotel,
            'transportasi' => $transportasi,
            'edit' => $paket 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //ddd($request); 
        $paket = Paket::findOrFail($id); 
        $validatedData = $request->validate([
            'destinasi_id' => 'required',
            'hotel_id' => 'required',
            'transportasi_id' => 'required', 
            'nama_paket' => 'required|max:255|unique:paket,nama_paket,' . $id,
            'harga' => 'required', 
            'status' => 'required|in:Tersedia,Full Booked',
        ]);

        $paket->update($validatedData); 
        return redirect()->route('backend.paket.index')->with('success', 'Data berhasil diperbaharui'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paket = paket::findOrFail($id); 
        $paket ->delete(); 
        return redirect()->route('backend.paket.index')->with('success', 'Data berhasil dihapus'); 
    }
}
