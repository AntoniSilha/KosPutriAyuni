@extends('layouts.app')

@section('title', 'Detail Pesanan - Kos Putri Ayuni')

@section('content')
<div class="min-h-screen bg-[#FDFBF7] pt-28 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center gap-4">
            <a href="{{ route('pesanan.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h1 class="text-2xl font-bold font-outfit text-gray-900">Detail Pesanan</h1>
        </div>

        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="p-6 sm:p-8 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <p class="text-sm text-gray-500 font-medium">No. Invoice</p>
                    <p class="text-lg font-bold text-gray-900">{{ $booking->invoice_number }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    @php
                        $color = match($booking->status) {
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'confirmed' => 'bg-green-100 text-green-800 border-green-200',
                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                            default => 'bg-gray-100 text-gray-800 border-gray-200',
                        };
                        if($booking->isExpired()) $color = 'bg-gray-100 text-gray-600 border-gray-200';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold border {{ $color }}">
                        {{ $booking->status_label }}
                    </span>
                </div>
            </div>

            <div class="p-6 sm:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kamar Info -->
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Informasi Kamar</h3>
                    <div class="flex gap-4 items-start">
                        <div class="w-24 h-24 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                            @if($booking->room->images->isNotEmpty())
                                <img src="{{ $booking->room->images->first()->img_url }}" alt="Kamar" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <img src="{{ asset('assets/img/room/room_fallback.jpg') }}" alt="Kamar" class="w-full h-full object-cover" loading="lazy">
                            @endif
                        </div>
                        <div>
                            <h4 class="font-outfit font-bold text-xl text-gray-900">Kamar {{ $booking->room->no_kamar ?? '-' }}</h4>
                            <p class="text-sm text-gray-500 mt-1">Durasi: {{ $duration }} Bulan</p>
                            <p class="text-sm text-gray-500">Check-in: {{ $booking->check_in ? $booking->check_in->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Rincian -->
                <div class="bg-[#FDFBF7] p-5 rounded-2xl border border-[#E8DFD8]">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Rincian Pembayaran</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Harga per bulan</span>
                            <span class="font-medium">Rp {{ number_format($booking->room->harga_perbulan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Durasi</span>
                            <span class="font-medium">x {{ $duration }} bulan</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 flex justify-between">
                            <span class="font-bold text-gray-900">Total Pembayaran</span>
                            <span class="font-bold text-xl text-[#8C6A4F]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Area -->
            <div class="p-6 sm:p-8 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-end gap-4 items-center">
                @if($booking->status === 'pending' && !$booking->isExpired())
                    @if($snapToken)
                        <div class="flex flex-col gap-3 w-full sm:w-auto">
                            @if($refreshLimitReached)
                                <p class="text-red-600 text-xs font-semibold text-center sm:text-right">
                                    ⚠️ Batas pergantian metode pembayaran telah tercapai (3x). Silakan selesaikan pembayaran dengan metode yang sudah dipilih atau hubungi admin.
                                </p>
                            @endif
                            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                                @if(!$refreshLimitReached)
                                    <button id="change-method-button" onclick="window.location.href='{{ route('pesanan.show', $booking->id_booking) }}?refresh_token=1';" class="hidden px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-xl font-bold hover:bg-gray-50 transition-all shadow-sm text-sm items-center justify-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        Ganti Metode ({{ $refreshRemaining }}x tersisa)
                                    </button>
                                @endif
                                <button id="pay-button" onclick="handlePay()" class="px-8 py-3 bg-[#8C6A4F] text-white rounded-xl font-bold hover:bg-[#5C4533] transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    Bayar Sekarang
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                            <strong>⚠️ Pembayaran belum tersedia.</strong><br>
                            <span class="text-xs">Gateway pembayaran sedang dalam konfigurasi. Silakan hubungi admin untuk informasi lebih lanjut.</span>
                        </div>
                    @endif
                @elseif ($booking->isExpired())
                    <div class="text-sm text-gray-500 bg-gray-100 rounded-xl px-4 py-3">
                        Pesanan ini telah kedaluwarsa.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($snapToken)
    @push('scripts')
    <!-- Midtrans Snap JS -->
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        var payBtnIcon = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>';

        function showChangeMethodButton() {
            var btn = document.getElementById('change-method-button');
            if (btn) {
                btn.classList.remove('hidden');
                btn.classList.add('flex');
            }
        }

        function handlePay() {
            var payButton = document.getElementById('pay-button');
            payButton.disabled = true;
            payButton.innerHTML = '<svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';

            snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    window.location.href = "{{ route('payment.finish') }}?order_id={{ $booking->invoice_number }}";
                },
                onPending: function (result) {
                    payButton.disabled = false;
                    payButton.innerHTML = payBtnIcon + ' Bayar Sekarang';
                    showChangeMethodButton();
                },
                onError: function (result) {
                    window.location.href = "{{ route('payment.error') }}?order_id={{ $booking->invoice_number }}";
                },
                onClose: function () {
                    payButton.disabled = false;
                    payButton.innerHTML = payBtnIcon + ' Bayar Sekarang';
                }
            });
        }

        // Force reload if browser restores page from BFCache
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
    @endpush
@endif
@endsection

