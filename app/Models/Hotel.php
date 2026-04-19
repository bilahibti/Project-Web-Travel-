<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    public $timestamps = false; 
    protected $table = "hotel"; 
    // protected $fillable = [nama_hotel]; 
    protected $fillable = [
        'nama_hotel',
        'alamat',
        'deskripsi',
        'rating',
        'harga_per_malam',
        'foto',
        'status'
    ]; 

}
