<?php

namespace App\Filament\Resident\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ActiveLeaseInfo extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $activeBooking = Booking::where('users_id_user', $user->id_user)
            ->whereIn('status', ['pending', 'confirmed'])
            ->latest()
            ->first();

        if (!$activeBooking) {
            return [
                Stat::make('Status Sewa', 'Tidak ada sewa aktif')
                    ->description('Anda belum memiliki booking aktif')
                    ->descriptionIcon('heroicon-m-x-circle')
                    ->color('gray'),
            ];
        }

        $stats = [];

        // Info Kamar
        $stats[] = Stat::make('Kamar Anda', 'Kamar ' . ($activeBooking->room->no_kamar ?? '-'))
            ->description($activeBooking->status === 'pending' ? 'Menunggu Pembayaran' : 'Sewa Aktif')
            ->descriptionIcon('heroicon-m-home')
            ->color($activeBooking->status === 'pending' ? 'warning' : 'success');

        // Sisa Waktu
        if ($activeBooking->status === 'confirmed' && $activeBooking->check_out) {
            $now = now();
            $checkOut = Carbon::parse($activeBooking->check_out);
            $daysLeft = (int) $now->diffInDays($checkOut, false);

            if ($daysLeft > 0) {
                $stats[] = Stat::make('Sisa Waktu Sewa', $daysLeft . ' Hari')
                    ->description('Berakhir pada ' . $checkOut->translatedFormat('d M Y'))
                    ->descriptionIcon('heroicon-m-clock')
                    ->color($daysLeft <= 7 ? 'danger' : 'info');
            } else {
                $stats[] = Stat::make('Sisa Waktu Sewa', 'Habis')
                    ->description('Masa sewa Anda telah berakhir')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('danger');
            }
        }

        // Total Tagihan / Pembayaran
        $stats[] = Stat::make('Total Tagihan', 'Rp ' . number_format($activeBooking->total_price, 0, ',', '.'))
            ->description($activeBooking->payment && $activeBooking->payment->isPaid() ? 'Lunas' : 'Belum Bayar')
            ->descriptionIcon('heroicon-m-banknotes')
            ->color($activeBooking->payment && $activeBooking->payment->isPaid() ? 'success' : 'warning');

        return $stats;
    }
}
