<?php

namespace App\Filament\Resident\Pages;

use App\Models\Booking;
use Filament\Pages\Page;

class Payments extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Payments';

    protected static ?string $title = 'Payments';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.resident.pages.payments';

    public function getBookings()
    {
        return Booking::query()
            ->with(['room', 'payment'])
            ->where('users_id_user', auth()->user()->id_user)
            ->latest('created_at')
            ->get();
    }

    public function formatCurrency(float | int | null $amount): string
    {
        return 'Rp ' . number_format((float) $amount, 0, ',', '.');
    }
}
