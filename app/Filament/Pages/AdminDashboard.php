<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Filament\Resources\Rooms\RoomResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Filament\Pages\Dashboard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class AdminDashboard extends Dashboard
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-squares-2x2'; //menampilkan icon sidebar

    protected static ?string $navigationLabel = 'Dashboard'; //nama menu

    protected static ?string $title = 'Dashboard Admin';

    protected string $view = 'filament.pages.admin-dashboard'; //menentukan tampilan yang akan digunakan diambil dari file admin-dashboard.blade.php

    public function getDashboardData(): array //mengambil seluruh data dashboard 
    {
        $deletedCount = app(\App\Services\BookingService::class)->expireOldBookings();
        if ($deletedCount > 0) {
            Cache::forget('admin_dashboard_data'); //menghapus booking kadaluarsa 
        }

        return Cache::remember('admin_dashboard_data', 300, function () {
            $totalRooms = Room::count(); //statistik kamar
            $occupiedRooms = Booking::query()
                ->whereIn('status', ['pending', 'confirmed'])
                ->whereNotNull('rooms_id_room')
                ->distinct('rooms_id_room')
                ->count('rooms_id_room');
            $availableRooms = Room::tersedia()->count();
            $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

            $currentMonth = now();
            $monthlyIncome = Payment::query()
                ->where('payment_status', 'approve')
                ->whereBetween('payment_time', [$currentMonth->copy()->startOfMonth(), $currentMonth->copy()->endOfMonth()])
                ->sum('total_pembayaran');
            $outstanding = Payment::query()
                ->where('payment_status', 'pending')
                ->sum('total_pembayaran');
            $refunds = Payment::query()
                ->where('payment_status', 'refund')
                ->sum('total_pembayaran');

            return [ //statistik kamar, pendapatan, dan aktivitas terbaru dan menampilkan di halaman blade
                'totalRooms' => $totalRooms,
                'occupiedRooms' => $occupiedRooms,
                'availableRooms' => $availableRooms,
                'occupancyRate' => $occupancyRate,
                'occupancyRate' => $occupancyRate,
                'monthlyIncome' => $monthlyIncome,
                'outstanding' => $outstanding,
                'refunds' => $refunds,
                'monthLabel' => $currentMonth->translatedFormat('F Y'),
                'trend' => $this->getResidentTrend(),
                'activities' => $this->getRecentActivities(),
                'links' => [ //tautan untuk beralih ke halaman tertentu
                    'rooms' => RoomResource::getUrl('index'), //kamar
                    'residents' => UserResource::getUrl('index'), //penghuni
                    'addResident' => UserResource::getUrl('create'), // tambah penghuni
                    'payments' => PaymentResource::getUrl('index'), //pembayaran 
                ],
            ];
        });
    }



    protected function getResidentTrend(): array
    {
        $hasCheckOut = Schema::hasColumn('bookings', 'check_out');

        return collect(range(5, 0))
            ->map(function (int $monthsAgo) use ($hasCheckOut): array {
                $date = now()->subMonths($monthsAgo);
                $start = $date->copy()->startOfMonth();
                $end = $date->copy()->endOfMonth();

                $query = Booking::query()
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->whereNotNull('rooms_id_room')
                    ->where('created_at', '<=', $end);

                if ($hasCheckOut) {
                    $query->where(function ($query) use ($start) {
                        $query->whereNull('check_out')
                            ->orWhere('check_out', '>=', $start);
                    });
                }

                return [
                    'label' => strtoupper($date->translatedFormat('M')),
                    'value' => $query->distinct('rooms_id_room')->count('rooms_id_room'),
                ];
            })
            ->all();
    }

    protected function getRecentActivities(): array
    {
        $payments = Payment::query()
            ->with(['booking.user', 'booking.room'])
            ->latest('payment_time')
            ->limit(2)
            ->get()
            ->map(fn (Payment $payment): array => [
                'title' => $payment->payment_status === 'approve' ? 'Pembayaran Diterima' : 'Update Pembayaran',
                'description' => ($payment->booking?->user?->name ?? 'Penghuni') . ' - ' . $this->formatCurrency((float) $payment->total_pembayaran),
                'time' => $payment->payment_time ? Carbon::parse($payment->payment_time)->diffForHumans() : 'Baru saja',
                'tone' => $payment->payment_status === 'approve' ? 'strong' : 'muted',
            ]);

        $bookings = Booking::query()
            ->with(['user', 'room'])
            ->latest('created_at')
            ->limit(2)
            ->get()
            ->map(fn (Booking $booking): array => [
                'title' => $booking->status === 'confirmed' ? 'Kontrak Aktif' : 'Pemesanan Baru',
                'description' => ($booking->user?->name ?? 'Penghuni') . ' (Kamar ' . ($booking->room?->no_kamar ?? '-') . ')',
                'time' => $booking->created_at ? Carbon::parse($booking->created_at)->diffForHumans() : 'Baru saja',
                'tone' => $booking->status === 'confirmed' ? 'strong' : 'muted',
            ]);

        return $payments
            ->merge($bookings)
            ->take(3)
            ->values()
            ->all();
    }

    public function formatCurrency(float | int | null $amount): string //mengubah format menjadi rupiah 
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }
}
