<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    public $timestamps = true; 
    protected $table = "paket"; 
    protected $fillable = [
        'nama_paket',
        'destinasi_id',
        'hotel_id',
        'transportasi_id',
        'durasi',
        'harga',
        'status'
    ]; 

    public function destinasi() 
    { 
        return $this->belongsTo(Destinasi::class); 
    } 

    public function hotel() 
    { 
        return $this->belongsTo(Hotel::class); 
    } 

    public function transportasi() 
    { 
        return $this->belongsTo(Transportasi::class); 
    }
}
