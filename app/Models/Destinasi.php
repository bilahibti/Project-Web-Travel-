<?php 

namespace App\Models; 
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model; 

class Destinasi extends Model 
{ 
    public $timestamps = false; 
    protected $table = "destinasi"; 
    // protected $fillable = [nama_destinasi]; 
    protected $fillable = [
        'nama_destinasi',
        'negara',
        'deskripsi',
        'lokasi',
        'harga_tiket',
        'status',
        'foto'
    ]; 
}

