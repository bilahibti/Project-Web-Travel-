<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportasi extends Model
{
    public $timestamps = false; 
    protected $table = "transportasi"; 
    // protected $fillable = [nama_destinasi]; 
    protected $fillable = [
        'jenis_transportasi',
        'nama_transportasi',
        'kota_keberangkatan',
        'kota_tujuan',
        'waktu_berangkat',
        'waktu_tiba',
        'harga',
        'status',
    ];
}
