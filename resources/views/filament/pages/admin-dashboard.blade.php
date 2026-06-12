<x-filament-panels::page class="kos-dashboard-page">
    @php
        $data = $this->getDashboardData();
        $trendMax = max(1, ...array_column($data['trend'], 'value'));
    @endphp

    <div class="kos-dashboard kos-admin-dashboard">
        <section class="kos-dashboard-hero">
            <div class="kos-occupancy-card">
                <div>
                    <p class="kos-eyebrow">Tingkat okupansi</p>
                    <p class="kos-display">{{ $data['occupancyRate'] }}%</p>
                    <p class="kos-copy">
                        {{ $data['occupiedRooms'] }} dari {{ $data['totalRooms'] }} unit terisi.
                        Tersisa {{ $data['availableRooms'] }} kamar tersedia untuk disewakan.
                    </p>
                </div>

                <div class="kos-building-mark" aria-hidden="true">
                    <svg viewBox="0 0 96 96" fill="none">
                        <path d="M21 78h54M33 78V25h27v53M60 35h12v43M42 38h6M42 52h6M42 66h6" stroke="currentColor" stroke-width="6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
            </div>

            <div class="kos-room-summary">
                <p class="kos-eyebrow">Total kamar: {{ $data['totalRooms'] }}</p>

                <div class="kos-room-row" style="border-bottom: none; padding-bottom: 0;">
                    <span>Terisi</span>
                    <strong>{{ $data['occupiedRooms'] }}</strong>
                </div>
                <div class="kos-room-row" style="border-bottom: none; padding-bottom: 0;">
                    <span>Tersedia</span>
                    <strong style="color: #0aa25b;">{{ $data['availableRooms'] }}</strong>
                </div>
            </div>
        </section>

        <section class="kos-section-head">
            <div>
                <h2>Ringkasan Keuangan</h2>
                <p>Laporan pendapatan bulan berjalan ({{ $data['monthLabel'] }})</p>
            </div>
            <a href="{{ $data['links']['payments'] }}">Lihat laporan lengkap</a>
        </section>

        <section class="kos-finance-grid">
            <article class="kos-metric-card">
                <p class="kos-eyebrow">Pendapatan kotor</p>
                <strong>{{ $this->formatCurrency($data['monthlyIncome']) }}</strong>
                <span class="kos-positive">Terkumpul bulan ini</span>
            </article>
            <article class="kos-metric-card">
                <p class="kos-eyebrow">Tunggakan</p>
                <strong>{{ $this->formatCurrency($data['outstanding']) }}</strong>
                <span>Tagihan dengan status pending</span>
            </article>
            <article class="kos-metric-card">
                <p class="kos-eyebrow">Pengeluaran ops.</p>
                <strong class="kos-danger">{{ $this->formatCurrency($data['refunds']) }}</strong>
                <span>Refund atau pembayaran keluar</span>
            </article>
        </section>

        <section class="kos-main-grid">
            <article class="kos-chart-card">
                <div class="kos-card-head">
                    <div>
                        <h3>Tren Penghuni</h3>
                        <p>Stabilitas hunian 6 bulan terakhir</p>
                    </div>
                    <span class="kos-legend"><i></i>Terisi</span>
                </div>

                <div class="kos-bar-chart">
                    @foreach ($data['trend'] as $item)
                        <div class="kos-bar-item">
                            <strong>{{ $item['value'] }}</strong>
                            <span style="height: {{ max(8, ($item['value'] / $trendMax) * 100) }}%"></span>
                            <small>{{ $item['label'] }}</small>
                        </div>
                    @endforeach
                </div>
            </article>

            <aside class="kos-activity-card">
                <h3>Aktivitas Terakhir</h3>
                <div class="kos-activity-list">
                    @forelse ($data['activities'] as $activity)
                        <div class="kos-activity-item {{ $activity['tone'] === 'strong' ? 'is-strong' : '' }}">
                            <span></span>
                            <div>
                                <strong>{{ $activity['title'] }}</strong>
                                <p>{{ $activity['description'] }}</p>
                                <small>{{ $activity['time'] }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="kos-empty">Belum ada aktivitas terbaru.</p>
                    @endforelse
                </div>
            </aside>
        </section>
    </div>
</x-filament-panels::page>
