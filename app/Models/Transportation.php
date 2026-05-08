<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    public $timestamps = false; 
    protected $table = "transportasi"; 
    // protected $fillable = [nama_destinasi]; 
    protected $fillable = [
        'transportation_name',
        'transportation_type',
        'departure_destination_id',
        'arrival_destination_id',
        'departure_time',
        'arrival_time',
        'price_per_person',
        'quota',
        'booked',
        'status',
    ];

    public function departureDestination()
    {
        return $this->belongsTo(Destination::class, 'departure_destination_id');
    }

    public function arrivalDestination()
    {
        return $this->belongsTo(Destination::class, 'arrival_destination_id');
    }
}
