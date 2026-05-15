<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class IncomeChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Pendapatan (6 Bulan Terakhir)';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Payment::where('payment_status', 'approve')
            ->where('payment_time', '>=', now()->subMonths(6))
            ->select(
                DB::raw('sum(total_pembayaran) as total'),
                DB::raw("DATE_FORMAT(payment_time, '%Y-%m') as month")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $amounts = [];

        // Fill missing months with 0
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->translatedFormat('F Y');
            
            $found = $data->firstWhere('month', $month);
            $amounts[] = $found ? (float) $found->total : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $amounts,
                    'fill' => 'start',
                    'tension' => 0.4,
                    'backgroundColor' => 'rgba(140, 106, 79, 0.1)',
                    'borderColor' => '#8C6A4F',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
