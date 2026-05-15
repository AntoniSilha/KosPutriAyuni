<?php

namespace App\Filament\Resident\Pages;

use App\Models\Booking;
use App\Services\SettingsService;
use Filament\Pages\Dashboard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class ResidentDashboard extends Dashboard
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Beranda Penghuni';

    protected string $view = 'filament.resident.pages.resident-dashboard';

    public function getDashboardData(): array
    {
        // First look for any pending booking (for payment/extension)
        $pendingBooking = Booking::query()
            ->with(['room.images', 'payment.billingPenghuni'])
            ->where('users_id_user', auth()->user()->id_user)
            ->where('status', 'pending')
            ->latest('created_at')
            ->first();

        // Then look for the confirmed active booking
        $confirmedBooking = Booking::query()
            ->with(['room.images', 'payment.billingPenghuni'])
            ->where('users_id_user', auth()->user()->id_user)
            ->where('status', 'confirmed')
            ->latest('check_in')
            ->first();

        // Active booking context (prioritize pending to prompt payment, else confirmed)
        $booking = $pendingBooking ?? $confirmedBooking;
        $room = $booking?->room;
        $payment = $booking?->payment;

        // Base values
        $amount = $payment?->total_pembayaran ?? data_get($booking, 'total_price') ?? $room?->harga_perbulan ?? 0;
        $dueDate = $payment?->billingPenghuni?->jatuh_tempo;
        if (! $dueDate && $booking?->created_at) {
            $dueDate = Carbon::parse($booking->created_at)->addDays(3);
        }

        $daysLeft = $dueDate ? now()->startOfDay()->diffInDays(Carbon::parse($dueDate)->startOfDay(), false) : null;
        $period = $this->getPeriodLabel($booking, $dueDate);

        // --- NEW: Lease End Date & Extend Logic ---
        $leaseEndDate = null;
        $gracePeriodDate = null;
        $canExtendLease = false;
        $daysUntilGrace = null;

        if ($confirmedBooking && $confirmedBooking->check_in) {
            $months = 1;
            if ($confirmedBooking->payment && $confirmedBooking->room && $confirmedBooking->room->harga_perbulan > 0) {
                $months = max(1, round($confirmedBooking->payment->total_pembayaran / $confirmedBooking->room->harga_perbulan));
            }
            $leaseEndDate = Carbon::parse($confirmedBooking->check_in)->addMonths($months);
            $gracePeriodDate = (clone $leaseEndDate)->addDays(2); // Kompensasi H+2

            $daysUntilGrace = now()->startOfDay()->diffInDays($gracePeriodDate->startOfDay(), false);

            // Sisa waktu sewa <= 3 hari lagi menuju H+2
            // Artinya: Jika sekarang sudah (Lease End - 1 hari), dan batasnya adalah (Lease End + 2 hari)
            // Tombol muncul jika jarak dari sekarang ke Grace Period <= 5 hari (3 hari sebelum end + 2 hari sesudah end)
            // As per user: "ketika waktu sewa sisa 3 hari lagi dan kompensasi waktu sewa h+2"
            // Let's use: if days from now to Lease End is <= 3.
            $daysToLeaseEnd = now()->startOfDay()->diffInDays($leaseEndDate->startOfDay(), false);
            
            // Can extend if within 3 days of lease end, OR past lease end but within grace period
            // And MUST NOT have an existing pending booking!
            if ($daysToLeaseEnd <= 3 && $daysUntilGrace >= 0 && !$pendingBooking) {
                $canExtendLease = true;
            }
        }

        // Get dynamic settings from SettingsService
        $settings = app(SettingsService::class);
        $announcements = $settings->getAnnouncements();
        $wifiSsid = $settings->get('wifi_ssid', 'Kos Putri Ayuni');
        $wifiPassword = $settings->get('wifi_password', '-');
        $infoText = $settings->get('info_text', '');

        if (empty($announcements)) {
            $announcements = [
                [
                    'date' => strtoupper(now()->translatedFormat('M d')),
                    'title' => 'Selamat Datang',
                    'description' => 'Belum ada pengumuman terbaru dari admin.',
                ],
            ];
        }

        return [
            'booking' => $booking,
            'confirmedBooking' => $confirmedBooking,
            'pendingBooking' => $pendingBooking,
            'room' => $room,
            'amount' => $amount,
            'period' => $period,
            'dueDate' => $dueDate,
            'daysLeft' => $daysLeft,
            'paymentUrl' => $booking ? route('pesanan.show', $booking->id_booking) : route('booking.create'),
            'roomType' => $this->getRoomTypeLabel($room?->deskripsi),
            'roomNumber' => $room?->no_kamar ?? '-',
            'leaseStatus' => $booking?->status === 'confirmed' ? 'Aktif' : ($booking ? 'Menunggu pembayaran' : 'Belum ada sewa'),
            'announcements' => $announcements,
            'wifiSsid' => $wifiSsid,
            'wifiPassword' => $wifiPassword,
            'infoText' => $infoText,
            // Extended logic
            'leaseEndDate' => $leaseEndDate,
            'gracePeriodDate' => $gracePeriodDate,
            'canExtendLease' => $canExtendLease,
        ];
    }

    public function extendLease()
    {
        $user = auth()->user();
        $confirmedBooking = Booking::where('users_id_user', $user->id_user)
            ->where('status', 'confirmed')
            ->latest('check_in')
            ->first();

        if (!$confirmedBooking) {
            return;
        }

        $months = 1;
        if ($confirmedBooking->payment && $confirmedBooking->room && $confirmedBooking->room->harga_perbulan > 0) {
            $months = max(1, round($confirmedBooking->payment->total_pembayaran / $confirmedBooking->room->harga_perbulan));
        }
        
        $nextCheckIn = Carbon::parse($confirmedBooking->check_in)->addMonths($months);
        $room = $confirmedBooking->room;
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));

        // Create new pending booking for the next month
        $newBooking = Booking::create([
            'invoice_number' => $invoiceNumber,
            'check_in' => $nextCheckIn->format('Y-m-d'),
            'status' => 'pending',
            'users_id_user' => $user->id_user,
            'rooms_id_room' => $room->id_room,
        ]);

        // Create payment record
        \App\Models\Payment::create([
            'bookings_id_booking' => $newBooking->id_booking,
            'transaction_id' => $invoiceNumber,
            'payment_method' => null,
            'total_pembayaran' => $room->harga_perbulan,
            'payment_status' => 'pending',
            'payment_time' => now(),
        ]);

        // Redirect to payment page
        return redirect()->route('pesanan.show', $newBooking->id_booking);
    }

    protected function getPeriodLabel(?Booking $booking, mixed $dueDate): string
    {
        if (! $booking) {
            return 'Belum ada tagihan aktif';
        }

        if ($booking->check_in) {
            return 'Mulai ' . Carbon::parse($booking->check_in)->translatedFormat('d F Y');
        }

        if ($dueDate) {
            $date = Carbon::parse($dueDate);

            return 'Periode 1 - ' . $date->translatedFormat('d F Y');
        }

        return $booking->check_in ? 'Mulai ' . Carbon::parse($booking->check_in)->translatedFormat('d F Y') : 'Periode berjalan';
    }

    protected function getRoomTypeLabel(?string $description): string
    {
        $description = strtolower((string) $description);

        return (str_contains($description, 'large') || str_contains($description, 'besar')) ? 'Large' : 'Reguler';
    }

    public function formatCurrency(float | int | null $amount): string
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }
}
