<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $fillable = ['booking_id', 'payment_code', 'amount', 'method', 'status', 'transaction_id', 'payment_detail', 'notes', 'paid_at'];
    protected $casts = ['payment_detail' => 'array', 'paid_at' => 'datetime', 'amount' => 'decimal:2'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payment) {
            if (!$payment->payment_code) {
                $payment->payment_code = 'PAY-' . strtoupper(Str::random(12));
            }
        });
    }

    public function booking() { return $this->belongsTo(Booking::class); }
}
