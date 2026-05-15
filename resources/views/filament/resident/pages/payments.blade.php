<x-filament-panels::page class="kos-dashboard-page">
    @php
        $bookings = $this->getBookings();
    @endphp

    <div class="kos-dashboard">
        <section class="kos-payments-list">
            @forelse ($bookings as $booking)
                @php
                    $payment = $booking->payment;
                    $amount = $payment?->total_pembayaran ?? data_get($booking, 'total_price') ?? $booking->room?->harga_perbulan ?? 0;
                    $status = $payment?->status_label ?? $booking->status_label;
                    $isPaid = $payment?->isPaid() ?? false;
                @endphp

                <article class="kos-payment-row">
                    <div>
                        <p class="kos-eyebrow">{{ $booking->invoice_number ?? 'Invoice belum tersedia' }}</p>
                        <h3>Kamar {{ $booking->room?->no_kamar ?? '-' }}</h3>
                        <span>{{ $booking->created_at ? $booking->created_at->translatedFormat('d F Y') : 'Tanggal belum tersedia' }}</span>
                    </div>
                    <strong>{{ $this->formatCurrency($amount) }}</strong>
                    <span class="kos-payment-status {{ $isPaid ? 'is-paid' : '' }}">{{ $status }}</span>
                    <a href="{{ route('pesanan.show', $booking->id_booking) }}">Detail</a>
                </article>
            @empty
                <article class="kos-empty-state">
                    <h3>Belum ada pembayaran</h3>
                    <p>Tagihan akan tampil setelah Anda membuat pesanan kamar.</p>
                    <a href="{{ route('booking.create') }}">Pesan kamar</a>
                </article>
            @endforelse
        </section>
    </div>
</x-filament-panels::page>
