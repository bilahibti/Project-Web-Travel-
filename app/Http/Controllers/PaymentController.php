<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'booking_id' => 'required|exists:booking,id',
            'method'     => 'required|in:bank_transfer,credit_card,debit_card,e_wallet,virtual_account,qris',
        ]);

        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->isPaid()) {
            return redirect()->back()->with('error', 'Booking ini sudah dibayar.');
        }

        $payment = Payment::create([
            'booking_id'   => $booking->id,
            'amount'       => $booking->total_price,
            'method'       => $request->method,
            'status'       => 'paid',   // simplified: langsung paid
            'paid_at'      => now(),
        ]);

        $booking->update(['status' => 'confirmed']);

        return redirect()->route('v1.frontend.booking.show', $booking->id)
            ->with('success', 'Payment successful!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with('payments')
        ->where('id', $bookingId)
        ->where('user_id', auth()->id())
        ->firstOrFail();

        return view('frontend.v_payment.show', compact('booking'));
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
