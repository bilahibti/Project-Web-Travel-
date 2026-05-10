<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TravelPackage;
use App\Models\Hotel;
use App\Models\HotelRoom;
use App\Models\Transportation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with(['packages.travelPackage', 'hotels.hotel', 'transports.transportation', 'payments'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data'    => $bookings,
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
        $booking = Booking::with([
            'user',
            'packages.travelPackage.destination',
            'hotels.hotel.destination',
            'hotels.room',
            'transports.transportation',
            'payments',
            'reviews',
        ])
        ->where('booking_code', $bookingCode)
        ->where('user_id', auth()->id())
        ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => $booking,
        ]);
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

    public function bookPackage(Request $request): JsonResponse
    {
        $request->validate([
            'travel_package_id' => 'required|exists:travel_packages,id',
            'travel_date'       => 'required|date|after:today',
            'persons'           => 'required|integer|min:1',
            'contact_name'      => 'required|string|max:100',
            'contact_phone'     => 'required|string|max:20',
            'contact_email'     => 'required|email',
            'notes'             => 'nullable|string',
        ]);

        $package = TravelPackage::findOrFail($request->travel_package_id);

        if (!$package->is_active) {
            return response()->json(['success' => false, 'message' => 'Paket tidak tersedia.'], 422);
        }

        if ($request->persons > $package->max_persons) {
            return response()->json(['success' => false, 'message' => "Maksimum {$package->max_persons} orang untuk paket ini."], 422);
        }

        $totalPrice  = $package->price * $request->persons;
        $tax         = $totalPrice * 0.11; // PPN 11%
        $grandTotal  = $totalPrice + $tax;
        $returnDate  = Carbon::parse($request->travel_date)->addDays($package->duration_days);

        return DB::transaction(function () use ($request, $package, $totalPrice, $tax, $grandTotal, $returnDate) {
            $booking = Booking::create([
                'user_id'       => auth()->id(),
                'type'          => 'package',
                'status'        => 'pending',
                'subtotal'      => $totalPrice,
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
                'travel_package_id' => $package->id,
                'persons'           => $request->persons,
                'unit_price'        => $package->price,
                'total_price'       => $totalPrice,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking paket berhasil dibuat. Lanjutkan ke pembayaran.',
                'data'    => $booking->load('packages.travelPackage'),
            ], 201);
        });
    }

    public function bookHotel(Request $request): JsonResponse
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
            'notes'         => 'nullable|string',
        ]);

        $room  = HotelRoom::with('hotel')->findOrFail($request->hotel_room_id);
        $hotel = Hotel::findOrFail($request->hotel_id);

        if (!$hotel->is_active) {
            return response()->json(['success' => false, 'message' => 'Hotel tidak tersedia.'], 422);
        }

        $available = $room->getAvailableRoomsForDate($request->check_in, $request->check_out);
        if ($request->rooms > $available) {
            return response()->json([
                'success' => false,
                'message' => "Hanya tersedia {$available} kamar untuk tanggal yang dipilih.",
            ], 422);
        }

        $nights     = Carbon::parse($request->check_in)->diffInDays($request->check_out);
        $subtotal   = $room->price_per_night * $request->rooms * $nights;
        $tax        = $subtotal * 0.11;
        $grandTotal = $subtotal + $tax;

        return DB::transaction(function () use ($request, $room, $hotel, $subtotal, $tax, $grandTotal, $nights) {
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
                'price_per_night' => $room->price_per_night,
                'total_price'     => $subtotal,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking hotel berhasil dibuat. Lanjutkan ke pembayaran.',
                'data'    => $booking->load('hotels.hotel', 'hotels.room'),
            ], 201);
        });
    }

    public function bookTransport(Request $request): JsonResponse
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
            'special_request'   => 'nullable|string',
        ]);

        $transport = Transportation::findOrFail($request->transportation_id);

        if (!$transport->isAvailableForDate($request->rental_date, $request->return_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak tersedia untuk tanggal yang dipilih.',
            ], 422);
        }

        $days       = Carbon::parse($request->rental_date)->diffInDays($request->return_date) ?: 1;
        $subtotal   = $transport->price_per_day * $days;
        $tax        = $subtotal * 0.11;
        $grandTotal = $subtotal + $tax;

        return DB::transaction(function () use ($request, $transport, $subtotal, $tax, $grandTotal, $days) {
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

            return response()->json([
                'success' => true,
                'message' => 'Booking transportasi berhasil dibuat. Lanjutkan ke pembayaran.',
                'data'    => $booking->load('transports.transportation'),
            ], 201);
        });
    }

    public function cancel(Booking $booking): JsonResponse
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Tidak diizinkan.'], 403);
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return response()->json(['success' => false, 'message' => 'Booking tidak dapat dibatalkan.'], 422);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibatalkan.',
        ]);
    }

}
