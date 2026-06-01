<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $totalRooms = Room::count();
        $availableRooms = Room::tersedia()->count();
        $activeResidents = User::whereHas('bookings', function ($query) {
            $query->whereIn('status', ['pending', 'confirmed']);
        })->count();

        $monthlyIncome = Payment::where('payment_status', 'approve')
            ->whereBetween('payment_time', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->sum('total_pembayaran');

        return [
            Stat::make('Total Kamar', $totalRooms)
                ->description('Total kapasitas kos')
                ->descriptionIcon('heroicon-m-home')
                ->color('info'),
            Stat::make('Kamar Tersedia', $availableRooms)
                ->description('Siap untuk disewa')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Penghuni Aktif', $activeResidents)
                ->description('User dengan booking aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($monthlyIncome, 0, ',', '.'))
                ->description('Total transaksi sukses')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
