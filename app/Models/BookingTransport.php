<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTransport extends Model
{
    protected $table = 'booking_transport';
    protected $fillable = ['booking_id', 'transportation_id', 'price_per_person', 'transport_total_price'];

    public function booking() { return $this->belongsTo(Booking::class); }
    public function transportation() { return $this->belongsTo(Transportation::class); }
}
