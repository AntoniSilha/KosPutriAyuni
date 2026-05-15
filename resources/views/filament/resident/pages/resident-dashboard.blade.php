<x-filament-panels::page class="kos-dashboard-page">
    @php
        $data = $this->getDashboardData();
        $booking = $data['booking'];
        $room = $data['room'];
        $roomImage = $room?->images?->first()?->img_url ?? asset('assets/img/TampilanKos.jpeg');
        $daysLeft = $data['daysLeft'];
    @endphp

    <div class="kos-dashboard kos-resident-dashboard">
        <section class="kos-billing-hero">
            <div class="kos-billing-copy">
                @if ($data['pendingBooking'])
                    <h2>Tagihan Menunggu Pembayaran</h2>
                    <p>{{ $data['period'] }}</p>
                    <strong>{{ $this->formatCurrency($data['amount']) }}</strong>
                    
                    <span class="kos-due-alert">
                        @if ($daysLeft !== null && $daysLeft >= 0)
                            Jatuh tempo dalam {{ (int) $daysLeft }} hari
                        @else
                            Menunggu pembayaran
                        @endif
                    </span>

                    <a href="{{ $data['paymentUrl'] }}" class="kos-primary-action">
                        Bayar Sekarang
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                @elseif ($data['confirmedBooking'])
                    <h2>Status Masa Sewa</h2>
                    <p>{{ $data['period'] }}</p>
                    <strong>{{ $this->formatCurrency($data['amount']) }}</strong>
                    
                    <span class="kos-paid-alert">Sewa Aktif & Terkonfirmasi</span>
                    
                    <!-- AlpineJS Countdown -->
                    <div x-data="leaseCountdown('{{ $data['leaseEndDate']?->toIso8601String() }}')" style="margin-top: 1.5rem; margin-bottom: 0.5rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <span style="font-size: 0.85rem; color: var(--kos-brown-dark); font-weight: 600;">Sisa waktu sewa:</span>
                        <div style="display: flex; gap: 0.5rem; font-family: monospace; font-size: 1.15rem; font-weight: bold; color: var(--kos-brown);">
                            <div style="background: white; padding: 0.4rem 0.6rem; border-radius: 0.35rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid #e8dfcc;"><span x-text="days"></span> hr</div>
                            <div style="background: white; padding: 0.4rem 0.6rem; border-radius: 0.35rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid #e8dfcc;"><span x-text="hours"></span> jm</div>
                            <div style="background: white; padding: 0.4rem 0.6rem; border-radius: 0.35rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid #e8dfcc;"><span x-text="minutes"></span> mn</div>
                            <div style="background: white; padding: 0.4rem 0.6rem; border-radius: 0.35rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid #e8dfcc;"><span x-text="seconds"></span> dt</div>
                        </div>
                        <span x-show="isExpired" style="display: none; color: #bf1118; font-size: 0.75rem; font-weight: 600; margin-top: 0.25rem;">
                            Masa sewa normal habis. Batas toleransi (H+2) berlaku.
                        </span>
                    </div>

                    @if ($data['canExtendLease'])
                        <button type="button" wire:click="extendLease" onclick="confirm('Anda akan membuat tagihan baru untuk memperpanjang kos selama 1 bulan. Lanjutkan?') || event.stopImmediatePropagation()" class="kos-primary-action" style="margin-top: 1rem; border: none; cursor: pointer; font-family: inherit;">
                            Perpanjang Sewa
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    @else
                        <button type="button" disabled class="kos-primary-action" style="margin-top: 1rem; border: none; cursor: not-allowed; font-family: inherit; opacity: 0.6; filter: grayscale(100%);" title="Tombol akan aktif saat sisa sewa kurang dari 3 hari.">
                            Perpanjang Sewa
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 6v6m0 0v6m0-6h6m-6 0H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        @if($data['leaseEndDate'])
                        <span style="display: block; margin-top: 0.75rem; font-size: 0.75rem; font-weight: 600; color: var(--kos-muted); text-align: center;">
                            * Tombol aktif pada <b style="font-weight: 800; color: var(--kos-brown);">{{ \Carbon\Carbon::parse($data['leaseEndDate'])->subDays(3)->translatedFormat('d M Y') }}</b>.
                        </span>
                        @endif
                    @endif
                @else
                    <h2>Belum Ada Pesanan</h2>
                    <span class="kos-muted-alert">Belum ada tagihan aktif</span>
                    <a href="{{ route('booking.create') }}" class="kos-primary-action">
                        Pesan Kamar
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                @endif
            </div>

            <div class="kos-room-photo">
                <img src="{{ $roomImage }}" alt="Kamar Kos Putri Ayuni">
            </div>
        </section>

        <section class="kos-resident-grid">
            <article class="kos-announcement-card">
                <div class="kos-card-title-row">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 13h3l8 5V6l-8 5H4v2Zm15-3v4m2-6v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h3>Pengumuman Penting</h3>
                </div>

                <div class="kos-announcement-list">
                    @foreach ($data['announcements'] as $announcement)
                        <div class="kos-announcement-item">
                            <time>{{ $announcement['date'] }}</time>
                            <div>
                                <strong>{{ $announcement['title'] }}</strong>
                                <p>{{ $announcement['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </article>

            <aside class="kos-room-info-card">
                <p class="kos-eyebrow">Informasi kamar</p>
                <div>
                    <span>Tipe kamar</span>
                    <strong>{{ $data['roomType'] }}</strong>
                </div>
                <div>
                    <span>No. kamar</span>
                    <strong>{{ $data['roomNumber'] }}</strong>
                </div>
                <div>
                    <span>Status sewa</span>
                    <p><i></i>{{ $data['leaseStatus'] }}</p>
                </div>

                {{-- WiFi Info Section --}}
                <div style="margin-top: 0.5rem; padding-top: 1rem; border-top: 1px solid rgba(118,96,53,0.12);">
                    <span>WiFi</span>
                    <div style="margin-top: 0.3rem;">
                        <p style="margin:0; font-size:0.85rem; color:#5b4827;"><strong style="font-size:1rem;">{{ $data['wifiSsid'] }}</strong></p>
                        <p style="margin:0.2rem 0 0; font-size:0.82rem; color:#756c55;">Password: <strong style="font-size:0.9rem; color:#766035;">{{ $data['wifiPassword'] ?: '-' }}</strong></p>
                    </div>
                </div>

                @if (!empty($data['infoText']))
                <div style="margin-top: 0.5rem; padding-top: 1rem; border-top: 1px solid rgba(118,96,53,0.12);">
                    <span>Info Penting</span>
                    <p style="margin:0.3rem 0 0; font-size:0.82rem; color:#5c5545; line-height:1.5;">{{ $data['infoText'] }}</p>
                </div>
                @endif
            </aside>
        </section>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('leaseCountdown', (endDateStr) => ({
                endDate: new Date(endDateStr).getTime(),
                now: new Date().getTime(),
                days: 0,
                hours: 0,
                minutes: 0,
                seconds: 0,
                isExpired: false,
                init() {
                    this.updateTime();
                    setInterval(() => {
                        this.updateTime();
                    }, 1000);
                },
                updateTime() {
                    this.now = new Date().getTime();
                    let distance = this.endDate - this.now;

                    if (distance < 0) {
                        this.isExpired = true;
                        this.days = 0;
                        this.hours = 0;
                        this.minutes = 0;
                        this.seconds = 0;
                        return;
                    }

                    this.isExpired = false;
                    this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
                }
            }))
        })
    </script>
    @endpush
</x-filament-panels::page>
