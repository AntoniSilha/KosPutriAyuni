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
                            'refund' => 'bg-blue-100 text-blue-800 border-blue-200',
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
                @elseif ($booking->canBeRefunded())
                    <button type="button" onclick="openRefundModal()" class="px-8 py-3 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2" style="background-color: #dc2626; color: #ffffff;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                        Batalkan & Ajukan Refund
                    </button>
                @elseif ($booking->status === 'refund')
                    <div class="w-full">
                        <div class="text-sm text-blue-700 bg-blue-50 border border-blue-200 rounded-2xl p-4 flex flex-col gap-2">
                            <div class="flex items-center gap-2 font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Pengembalian Dana (Refund) Telah Diproses
                            </div>
                            @if($booking->refund)
                                <div class="text-xs text-blue-600 space-y-1 mt-1 border-t border-blue-100 pt-2">
                                    <p><strong>Alasan:</strong> {{ $booking->refund->reason }}</p>
                                    <p><strong>Total Dana:</strong> Rp {{ number_format($booking->refund->total, 0, ',', '.') }}</p>
                                    <p><strong>Waktu Refund:</strong> {{ $booking->refund->refund_time ? $booking->refund->refund_time->format('d M Y, H:i') : '-' }}</p>
                                </div>
                            @endif
                        </div>
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

@if($booking->canBeRefunded())
    <!-- Refund Modal -->
    <div id="refundModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm transition-opacity" onclick="closeRefundModal()"></div>

        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                <!-- Header -->
                <div class="bg-gray-50 px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold font-outfit text-gray-900" id="modal-title">Pengajuan Refund Perpanjangan</h3>
                    <button type="button" onclick="closeRefundModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form action="{{ route('pesanan.refund', $booking->id_booking) }}" method="POST" id="refundForm">
                    @csrf
                    <!-- Body -->
                    <div class="px-6 py-6 space-y-4">
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-amber-800 text-sm">
                            <p class="font-semibold mb-1">Penting:</p>
                            <p class="text-xs">Dengan mengajukan pembatalan perpanjangan sewa ini, status sewa Anda akan dihentikan pada masa perpanjangan berikutnya, dan dana yang telah dibayarkan akan di-refund.</p>
                        </div>

                        <div>
                            <label for="reason" class="block text-sm font-bold text-gray-700 mb-2">Alasan Pembatalan / Refund <span class="text-red-500">*</span></label>
                            <textarea id="reason" name="reason" rows="4" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-[#8C6A4F] focus:ring-1 focus:ring-[#8C6A4F] outline-none text-sm transition-all" placeholder="Tulis alasan pembatalan Anda di sini (contoh: salah memilih kamar, rencana perpanjangan berubah, dll.)"></textarea>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <button type="button" onclick="closeRefundModal()" class="w-full sm:w-auto px-5 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 font-bold hover:bg-gray-50 transition-colors text-sm">
                            Batal
                        </button>
                        <button type="submit" id="submitRefundBtn" class="w-full sm:w-auto px-6 py-2.5 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition-colors text-sm shadow-md flex items-center justify-center gap-2" style="background-color: #dc2626; color: #ffffff;">
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openRefundModal() {
            const modal = document.getElementById('refundModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeRefundModal() {
            const modal = document.getElementById('refundModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        document.getElementById('refundForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitRefundBtn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengirim...';
            }
        });
    </script>
    @endpush
@endif
@endsection

