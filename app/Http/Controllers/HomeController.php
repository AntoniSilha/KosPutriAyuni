<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;

use App\Services\BookingService;

class HomeController extends Controller
{
    /**
     * Show landing page
     */
    public function index(BookingService $bookingService)
    {
        // Clean up expired bookings
        $bookingService->expireOldBookings();

        // Get all rooms (including maintenance and unavailable) to show user info
        $rooms = Room::with('images')->get();

        $testimonials = [
            [
                'name' => 'Sari Dewi',
                'text' => 'Kos Putri Ayuni sangat nyaman dan bersih. Pelayanan 24 jam membuat saya merasa aman.',
                'rating' => 5,
            ],
            [
                'name' => 'Rina Wati',
                'text' => 'Lokasi strategis dekat kampus dan harganya sangat terjangkau. Recommended!',
                'rating' => 5,
            ],
            [
                'name' => 'Indah Permata',
                'text' => 'Fasilitas lengkap dengan WiFi gratis. Lingkungan tenang dan cocok untuk belajar.',
                'rating' => 4,
            ],
            [
                'name' => 'Putri Amalya',
                'text' => 'Sudah 2 tahun di sini dan selalu merasa nyaman. Ibu kosnya baik sekali!',
                'rating' => 5,
            ],
        ];

        $stats = [
            'total_rooms' => Room::count(),
            'available_rooms' => Room::tersedia()->count(),
            'occupied_rooms' => Room::where('status', 'tidak tersedia')->count(),
        ];

        return view('home', compact('rooms', 'testimonials', 'stats'));
    }

    /**
     * Show about page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Show room detail page
     */
    public function showRoom(int $id)
    {
        $room = Room::with('images')->findOrFail($id);

        // Get other rooms for "Kamar Lainnya" section (exclude current room)
        $otherRooms = Room::with('images')
            ->where('id_room', '!=', $id)
            ->limit(4)
            ->get();

        return view('room.show', compact('room', 'otherRooms'));
    }
}
