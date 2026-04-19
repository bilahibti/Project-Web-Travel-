<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destinasi;
use App\Models\Paket;
use App\Models\Hotel;
use App\Models\Transportasi;

class BerandaController extends Controller
{
    public function berandaBackend() 
    { 
        $paket = Paket::all();
        $hotel = Hotel::all();
        $transportasi = Transportasi::all();
        $destinasi = Destinasi::all();
        
        return view('backend.v_beranda.index', compact(
            'paket',
            'hotel',
            'transportasi',
            'destinasi'
        )); 
    } 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinasi = Destinasi::where('status', 'Tersedia')->orderBy('updated_at', 'desc')->paginate(6); 
        return view('frontend.v_beranda.index', [ 
            'judul' => 'Halan Beranda', 
            'destinasi' => $destinasi, 
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
