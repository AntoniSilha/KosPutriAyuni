<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Room;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        protected BookingService $bookingService
    ) {}

    /**
     * Show booking form
     */
    public function create(Request $request)
    {
        $rooms = Room::with('images')->tersedia()->get();

        $selectedRoom = null;
        if ($request->filled('room_id')) {
            $selectedRoom = Room::with('images')->find($request->room_id);
        }

        return view('booking.create', compact('rooms', 'selectedRoom'));
    }

    /**
     * Store a new booking
     */
    public function store(BookingRequest $request)
    {
        $user = auth()->user();
        
        // Prevent multiple bookings per user
        if ($user->booking()->exists()) {
            return back()->with('error', 'Anda sudah memiliki booking aktif. Satu akun hanya diperbolehkan memiliki satu booking.');
        }

        $room = Room::findOrFail($request->room_id);

        // Validate room is available (not full or under maintenance)
        if ($room->status !== 'tersedia') {
            $message = match($room->status) {
                'tidak tersedia' => 'Maaf, kamar ini sudah penuh dan tidak dapat dipesan. Silakan pilih kamar lain.',
                'perbaikan' => 'Maaf, kamar ini sedang dalam perbaikan dan tidak dapat dipesan saat ini.',
                default => 'Maaf, kamar ini tidak tersedia untuk dipesan.',
            };
            return back()->with('error', $message)->withInput();
        }

        // Calculate check_out from durasi
        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = $checkIn->copy()->addMonths((int) $request->durasi);

        try {
            $booking = $this->bookingService->createBooking($user, $room, [
                'check_in' => $request->check_in,
                'check_out' => $checkOut->format('Y-m-d'),
            ]);

            return redirect()->route('pesanan.show', $booking->id_booking)
                ->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }
}
