<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TravelPackages;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\Transportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    // ─────────────────────────────────────────────
    //  FRONTEND CUSTOMER
    // ─────────────────────────────────────────────

    /**
     * Daftar semua booking milik user yang login.
     */
    public function myBookings()
    {
        $bookings = Booking::with([
                'packages.travelPackage',
                'hotels.hotel',
                'transports.transportation',
                'payments',
            ])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('frontend.v_booking.index', compact('bookings'));
    }

    /**
     * Detail satu booking milik user yang login.
     */
    public function myBookingDetail(string $id)
    {
        $booking = Booking::with([
                'packages.travelPackage.destination',
                'hotels.hotel.destination',
                'hotels.room',
                'transports.transportation',
                'payments',
            ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('frontend.v_booking.show', compact('booking'));
    }

    // ─────────────────────────────────────────────
    //  BOOKING — PACKAGE
    // ─────────────────────────────────────────────

    /**
     * Proses booking paket wisata.
     * POST /v1/booking/package
     */
    public function bookPackage(Request $request)
    {
        $request->validate([
            'travel_package_id' => 'required|exists:travel_packages,id',
            'travel_date'       => 'required|date|after:today',
            'persons'           => 'required|integer|min:1|max:50',
            'contact_name'      => 'required|string|max:100',
            'contact_phone'     => 'required|string|max:20',
            'contact_email'     => 'required|email',
            'notes'             => 'nullable|string|max:500',
        ]);

        $package = TravelPackages::findOrFail($request->travel_package_id);

        // Validasi ketersediaan
        if (!$package->is_active) {
            return back()->withErrors(['travel_package_id' => 'Paket wisata tidak tersedia.'])->withInput();
        }

        if ($request->persons > $package->max_persons) {
            return back()->withErrors(['persons' => "Maksimal {$package->max_persons} orang untuk paket ini."])->withInput();
        }

        // Hitung harga
        $subtotal   = $package->price_packages * $request->persons;
        $tax        = $subtotal * 0.11;            // PPN 11 %
        $grandTotal = $subtotal + $tax;
        $returnDate = Carbon::parse($request->travel_date)->addDays($package->duration_days ?? 1);

        $booking = DB::transaction(function () use ($request, $package, $subtotal, $tax, $grandTotal, $returnDate) {
            $booking = Booking::create([
                'user_id'       => auth()->id(),
                'type'          => 'package',
                'status'        => 'pending',
                'subtotal'      => $subtotal,
                'tax'           => $tax,
                'total_price'   => $grandTotal,
                'travel_date'   => $request->travel_date,
                'return_date'   => $returnDate,
                'total_persons' => $request->persons,
                'contact_name'  => $request->contact_name,
                'contact_phone' => $request->contact_phone,
                'contact_email' => $request->contact_email,
                'notes'         => $request->notes,
            ]);

            $booking->packages()->create([
                'travel_package_id'    => $package->id,
                'persons'              => $request->persons,
                'unit_price'           => $package->price_packages,
                'packages_total_price' => $subtotal,
            ]);

            return $booking;
        });

        return redirect()
            ->route('v1.payment.show', $booking->id)
            ->with('success', 'Booking berhasil dibuat! Silakan selesaikan pembayaran.');
    }

    // ─────────────────────────────────────────────
    //  BOOKING — HOTEL
    // ─────────────────────────────────────────────

    /**
     * Proses booking hotel.
     * POST /v1/booking/hotel
     */
    public function bookHotel(Request $request)
    {
        $request->validate([
            'hotel_id'      => 'required|exists:hotels,id',
            'hotel_room_id' => 'required|exists:hotel_rooms,id',
            'check_in'      => 'required|date|after:today',
            'check_out'     => 'required|date|after:check_in',
            'rooms'         => 'required|integer|min:1',
            'contact_name'  => 'required|string|max:100',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email',
            'notes'         => 'nullable|string|max:500',
        ]);

        $hotel = Hotel::findOrFail($request->hotel_id);
        $room  = HotelRoom::findOrFail($request->hotel_room_id);

        if (!$hotel->is_active) {
            return back()->withErrors(['hotel_id' => 'Hotel tidak tersedia.'])->withInput();
        }

        // Cek ketersediaan kamar
        $bookedRooms = $room->bookings()
            ->whereHas('booking', fn($q) => $q
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->where('travel_date', '<', $request->check_out)
                ->where('return_date', '>', $request->check_in)
            )->sum('rooms');

        $available = $room->total_rooms - $bookedRooms;
        if ($request->rooms > $available) {
            return back()->withErrors(['rooms' => "Hanya {$available} kamar tersedia untuk tanggal yang dipilih."])->withInput();
        }

        $nights     = Carbon::parse($request->check_in)->diffInDays($request->check_out);
        $subtotal   = $room->price_per_night * $request->rooms * $nights;
        $tax        = $subtotal * 0.11;
        $grandTotal = $subtotal + $tax;

        $booking = DB::transaction(function () use ($request, $hotel, $room, $subtotal, $tax, $grandTotal, $nights) {
            $booking = Booking::create([
                'user_id'       => auth()->id(),
                'type'          => 'hotel',
                'status'        => 'pending',
                'subtotal'      => $subtotal,
                'tax'           => $tax,
                'total_price'   => $grandTotal,
                'travel_date'   => $request->check_in,
                'return_date'   => $request->check_out,
                'total_persons' => $request->rooms,
                'contact_name'  => $request->contact_name,
                'contact_phone' => $request->contact_phone,
                'contact_email' => $request->contact_email,
                'notes'         => $request->notes,
            ]);

            $booking->hotels()->create([
                'hotel_id'        => $hotel->id,
                'hotel_room_id'   => $room->id,
                'check_in'        => $request->check_in,
                'check_out'       => $request->check_out,
                'rooms'           => $request->rooms,
                'nights'          => $nights,
                'price_per_night' => $room->price_per_night,
                'total_price'     => $subtotal,
            ]);

            return $booking;
        });

        return redirect()
            ->route('v1.payment.show', $booking->id)
            ->with('success', 'Booking hotel berhasil dibuat! Silakan selesaikan pembayaran.');
    }

    // ─────────────────────────────────────────────
    //  BOOKING — TRANSPORT
    // ─────────────────────────────────────────────

    /**
     * Proses booking transportasi.
     * POST /v1/booking/transport
     */
    public function bookTransport(Request $request)
    {
        $request->validate([
            'transportation_id' => 'required|exists:transportations,id',
            'rental_date'       => 'required|date|after:today',
            'return_date'       => 'required|date|after:rental_date',
            'pickup_location'   => 'required|string|max:255',
            'dropoff_location'  => 'nullable|string|max:255',
            'contact_name'      => 'required|string|max:100',
            'contact_phone'     => 'required|string|max:20',
            'contact_email'     => 'required|email',
            'special_request'   => 'nullable|string|max:500',
        ]);

        $transport = Transportation::findOrFail($request->transportation_id);

        if (!$transport->is_active) {
            return back()->withErrors(['transportation_id' => 'Transportasi tidak tersedia.'])->withInput();
        }

        // Cek ketersediaan
        $bookedCount = $transport->bookings()
            ->whereHas('booking', fn($q) => $q
                ->whereNotIn('status', ['cancelled', 'refunded'])
                ->where('travel_date', '<', $request->return_date)
                ->where('return_date', '>', $request->rental_date)
            )->count();

        if ($bookedCount >= $transport->quota) {
            return back()->withErrors(['transportation_id' => 'Transportasi tidak tersedia untuk tanggal yang dipilih.'])->withInput();
        }

        $days       = max(1, Carbon::parse($request->rental_date)->diffInDays($request->return_date));
        $subtotal   = $transport->price_per_day * $days;
        $tax        = $subtotal * 0.11;
        $grandTotal = $subtotal + $tax;

        $booking = DB::transaction(function () use ($request, $transport, $subtotal, $tax, $grandTotal, $days) {
            $booking = Booking::create([
                'user_id'       => auth()->id(),
                'type'          => 'transport',
                'status'        => 'pending',
                'subtotal'      => $subtotal,
                'tax'           => $tax,
                'total_price'   => $grandTotal,
                'travel_date'   => $request->rental_date,
                'return_date'   => $request->return_date,
                'total_persons' => 1,
                'contact_name'  => $request->contact_name,
                'contact_phone' => $request->contact_phone,
                'contact_email' => $request->contact_email,
            ]);

            $booking->transports()->create([
                'transportation_id' => $transport->id,
                'rental_date'       => $request->rental_date,
                'return_date'       => $request->return_date,
                'days'              => $days,
                'price_per_day'     => $transport->price_per_day,
                'total_price'       => $subtotal,
                'pickup_location'   => $request->pickup_location,
                'dropoff_location'  => $request->dropoff_location,
                'special_request'   => $request->special_request,
            ]);

            return $booking;
        });

        return redirect()
            ->route('v1.payment.show', $booking->id)
            ->with('success', 'Booking transportasi berhasil dibuat! Silakan selesaikan pembayaran.');
    }

    // ─────────────────────────────────────────────
    //  CANCEL BOOKING
    // ─────────────────────────────────────────────

    /**
     * Batalkan booking.
     * PUT /v1/booking/{id}/cancel
     */
    public function cancel(string $id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->withErrors(['cancel' => 'Booking tidak dapat dibatalkan.']);
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()
            ->route('v1.booking.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }

    // ─────────────────────────────────────────────
    //  BACKEND ADMIN
    // ─────────────────────────────────────────────

    /**
     * Daftar semua booking (backend).
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'payments'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('backend.v_booking.index', compact('bookings'));
    }

    /**
     * Detail booking (backend).
     */
    public function show(string $id)
    {
        $booking = Booking::with([
            'user',
            'packages.travelPackage',
            'hotels.hotel',
            'hotels.room',
            'transports.transportation',
            'payments',
        ])->findOrFail($id);

        return view('backend.v_booking.show', compact('booking'));
    }

    /**
     * Update status booking (backend).
     */
    public function updateStatus(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,in_progress,completed,cancelled,refunded',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()
            ->back()
            ->with('success', 'Status booking berhasil diupdate.');
    }
}