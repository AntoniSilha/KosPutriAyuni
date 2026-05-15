@extends('layouts.app')

@section('title', 'Invoice - Kos Putri Ayuni')

@section('content')
<div class="min-h-screen bg-[#FDFBF7] pt-28 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden print:shadow-none print:border-none">
            <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold font-outfit text-gray-900">INVOICE</h2>
                    <p class="text-gray-500 mt-1">#{{ $booking->invoice_number }}</p>
                </div>
                <div class="text-right">
                    <div class="font-outfit font-bold text-xl text-[#8C6A4F] mb-1">Kos Putri Ayuni</div>
                    <p class="text-xs text-gray-500">Jl. Contoh Kos Putri No. 123</p>
                    <p class="text-xs text-gray-500">cs@kosayuni.com</p>
                </div>
            </div>

            <div class="p-8 grid grid-cols-2 gap-8 border-b border-gray-100">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Ditagihkan Kepada:</p>
                    <p class="font-bold text-gray-900">{{ $booking->user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                    <p class="text-sm text-gray-600">{{ $booking->user->no_hp }}</p>
                </div>
                <div class="text-right">
                    <div class="mb-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal Invoice:</p>
                        <p class="font-medium text-gray-900">{{ $booking->created_at->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status Pembayaran:</p>
                        @php
                            $statusLabel = 'UNPAID';
                            $statusColor = 'text-red-600';
                            
                            if ($booking->payment && $booking->payment->isPaid()) {
                                $statusLabel = 'PAID';
                                $statusColor = 'text-green-600';
                            }
                        @endphp
                        <p class="font-bold {{ $statusColor }} text-lg">{{ $statusLabel }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th class="py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Harga/Bulan</th>
                            <th class="py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $duration = 1;
                            if ($booking->check_in && $booking->check_out) {
                                $duration = $booking->check_in->diffInMonths($booking->check_out);
                            }
                        @endphp
                        <tr>
                            <td class="py-4 text-sm text-gray-900">
                                <span class="font-medium">Sewa Kamar {{ $booking->room->no_kamar ?? '-' }}</span><br>
                                <span class="text-xs text-gray-500">Periode: {{ $booking->check_in ? $booking->check_in->format('d M Y') : '-' }} - {{ $booking->check_out ? $booking->check_out->format('d M Y') : '-' }}</span>
                            </td>
                            <td class="py-4 text-sm text-center text-gray-900">{{ $duration }} Bulan</td>
                            <td class="py-4 text-sm text-right text-gray-900">Rp {{ number_format($booking->room->harga_perbulan, 0, ',', '.') }}</td>
                            <td class="py-4 text-sm font-medium text-right text-gray-900">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="py-4 text-right font-bold text-gray-900">Grand Total:</td>
                            <td class="py-4 text-right font-bold text-xl text-[#8C6A4F]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="p-8 border-t border-gray-100 bg-gray-50 flex justify-between items-center print:hidden">
                <a href="{{ route('pesanan.show', $booking->id_booking) }}" class="text-gray-500 hover:text-gray-700 font-medium">Kembali</a>
                <button onclick="window.print()" class="px-6 py-2 bg-gray-900 text-white rounded-lg font-medium hover:bg-gray-800 transition shadow">
                    Cetak Invoice
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
