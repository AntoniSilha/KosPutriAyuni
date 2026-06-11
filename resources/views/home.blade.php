@extends('layouts.app')

@section('content')
<style>
    /* Default (Mobile, 1 column): Show only first 2 items if not expanded */
    .rooms-grid:not(.is-expanded) .room-card-item:nth-child(n+3) {
        display: none !important;
    }

    /* Tablet (SM, 2 columns): Show only first 4 items if not expanded */
    @media (min-width: 640px) {
        .rooms-grid:not(.is-expanded) .room-card-item:nth-child(n+3) {
            display: block !important;
        }
        .rooms-grid:not(.is-expanded) .room-card-item:nth-child(n+5) {
            display: none !important;
        }
    }

    /* Desktop (LG, 3 columns): Show only first 6 items if not expanded */
    @media (min-width: 1024px) {
        .rooms-grid:not(.is-expanded) .room-card-item:nth-child(n+5) {
            display: block !important;
        }
        .rooms-grid:not(.is-expanded) .room-card-item:nth-child(n+7) {
            display: none !important;
        }
    }
</style>

<!-- Hero Section -->
<section class="relative h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0 bg-gray-900">
        <img src="{{ asset('assets/img/home/hero.png') }}" alt="Kos Kosan" class="w-full h-full object-cover opacity-50 hero-img" loading="lazy" />
    </div>
    
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto gs-hero-content">
        <h1 class="text-white text-3xl sm:text-5xl md:text-7xl font-bold font-outfit mb-4 sm:mb-6 tracking-tight">
            Hunian Nyaman, Aman, dan Bersih
        </h1>
        <p class="text-gray-200 text-base sm:text-lg md:text-2xl mb-8 sm:mb-10 max-w-2xl mx-auto font-light">
            Temukan kenyamanan layaknya di rumah sendiri. Khusus putri, lokasi strategis.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4 px-4 sm:px-0">
            <a href="#tipe-kamar" class="px-8 py-4 bg-[#8C6A4F] text-white rounded-full font-semibold text-lg hover:bg-[#5C4533] transition shadow-lg hover:shadow-xl hover:-translate-y-1 inline-flex items-center justify-center">
                Book Now
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="{{ route('about') }}" class="px-8 py-4 bg-white/20 backdrop-blur-md text-white border border-white/50 rounded-full font-semibold text-lg hover:bg-white/30 transition inline-flex items-center justify-center">
                Learn More
            </a>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-24 bg-[#FDFBF7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">
            <div class="gs-fade-right order-2 md:order-1">
                <div class="text-sm font-bold text-[#8C6A4F] uppercase tracking-wider mb-2">About Us</div>
                <h2 class="text-4xl md:text-5xl font-bold font-outfit text-gray-900 mb-6 leading-tight">
                    Kos Putri Ayuni
                </h2>
                <p class="text-lg text-gray-600 leading-relaxed mb-8">
                    Kos Putri Ayuni adalah hunian nyaman, aman, dan bersih khusus perempuan dengan fasilitas lengkap serta lingkungan yang tenang dan strategis untuk menunjang aktivitas sehari-hari Anda.
                </p>
                <div class="grid grid-cols-2 gap-6">
                    <div class="flex items-start gap-3">
                        <div class="mt-1 bg-[#8C6A4F]/10 p-2 rounded-full text-[#8C6A4F]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Pelayanan 24 Jam</h4>
                            <p class="text-sm text-gray-500">Bantuan selalu tersedia</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-1 bg-[#8C6A4F]/10 p-2 rounded-full text-[#8C6A4F]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Harga Terjangkau</h4>
                            <p class="text-sm text-gray-500">Kualitas premium</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-1 bg-[#8C6A4F]/10 p-2 rounded-full text-[#8C6A4F]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Free WiFi & Listrik</h4>
                            <p class="text-sm text-gray-500">Tanpa biaya tambahan</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-1 bg-[#8C6A4F]/10 p-2 rounded-full text-[#8C6A4F]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Dekat Kampus</h4>
                            <p class="text-sm text-gray-500">Akses strategis</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative gs-fade-left order-1 md:order-2">
                <div class="absolute inset-0 bg-[#8C6A4F] rounded-2xl transform translate-x-3 translate-y-3 sm:translate-x-4 sm:translate-y-4"></div>
                <img src="{{ asset('assets/img/home/tampilan_kos.jpeg') }}" alt="Tampilan Kos" class="relative rounded-2xl shadow-xl w-full object-cover h-[280px] sm:h-[400px] md:h-[500px]" loading="lazy" />
            </div>
        </div>
    </div>
</section>

<!-- Why Us Section -->
<section id="why-us" class="py-24 bg-[#5C4533] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 gs-fade-up">
            <h2 class="text-4xl font-bold font-outfit mb-4">Mengapa Memilih Kami?</h2>
            <p class="text-gray-300 text-lg">Keunggulan yang membedakan Kos Putri Ayuni dengan kos lainnya.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20 gs-stagger-card hover:bg-white/20 transition duration-300">
                <div class="w-14 h-14 bg-[#8C6A4F] rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <h3 class="text-xl font-bold font-outfit mb-3">Fasilitas Eksklusif</h3>
                <p class="text-gray-300">Dilengkapi dengan perabotan modern, AC, kamar mandi dalam, dan ruang bersantai bersama.</p>
            </div>
            
            <!-- Card 2 -->
            <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20 gs-stagger-card hover:bg-white/20 transition duration-300">
                <div class="w-14 h-14 bg-[#8C6A4F] rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold font-outfit mb-3">Affordable Price</h3>
                <p class="text-gray-300">Penawaran harga terbaik yang sepadan dengan fasilitas premium yang Anda dapatkan.</p>
            </div>
            
            <!-- Card 3 -->
            <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20 gs-stagger-card hover:bg-white/20 transition duration-300">
                <div class="w-14 h-14 bg-[#8C6A4F] rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-bold font-outfit mb-3">Keamanan Prioritas</h3>
                <p class="text-gray-300">Dilengkapi CCTV 24 jam dan akses masuk menggunakan sistem pintar untuk keamanan maksimal.</p>
            </div>
        </div>
    </div>
</section>

<!-- Room Types Section -->
<section id="tipe-kamar" class="py-16 sm:py-24 bg-[#FDFBF7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 sm:mb-16 gs-fade-up">
            <div class="max-w-2xl">
                <div class="text-sm font-bold text-[#8C6A4F] uppercase tracking-wider mb-2">Tipe Kamar</div>
                <h2 class="text-4xl md:text-5xl font-bold font-outfit text-gray-900 leading-tight">Detail Kamar Kami</h2>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8 rooms-grid">
            @forelse($rooms as $room)
            @php
                $statusBadge = match($room->status) {
                    'tersedia' => ['text' => 'Tersedia', 'color' => 'text-green-600 bg-green-50 border-green-100'],
                    'tidak tersedia' => ['text' => 'Penuh', 'color' => 'text-red-600 bg-red-50 border-red-100'],
                    'perbaikan' => ['text' => 'Sedang Perbaikan', 'color' => 'text-amber-600 bg-amber-50 border-amber-100'],
                    default => ['text' => ucfirst($room->status), 'color' => 'text-gray-600 bg-gray-50 border-gray-100'],
                };
                $isBookable = $room->status === 'tersedia';
            @endphp
            <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 group gs-stagger-room room-card-item {{ !$isBookable ? 'opacity-85' : '' }}">
                <!-- Dynamic Image Gallery with GSAP -->
                <div class="relative h-48 sm:h-64 overflow-hidden room-gallery-container cursor-pointer">
                    @forelse($room->images as $index => $img)
                        <img src="{{ $img->img_url }}" 
                             alt="Kamar {{ $room->no_kamar }}" 
                             class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 gallery-img {{ $index === 0 ? 'opacity-100 active' : 'opacity-0' }}"
                             data-room="{{ $room->id_room }}"
                             loading="lazy">
                    @empty
                        <img src="{{ asset('assets/img/room/room_fallback.jpg') }}" alt="Kamar {{ $room->no_kamar }}" class="w-full h-full object-cover" loading="lazy">
                    @endforelse
                    
                    <div class="absolute top-4 right-4 z-10 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold shadow border {{ $statusBadge['color'] }}">
                        {{ $statusBadge['text'] }}
                    </div>
                    
                    @if($room->images->count() > 1)
                        <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-1.5 z-10">
                            @foreach($room->images as $i => $img)
                                <div class="w-1.5 h-1.5 rounded-full bg-white/50 gallery-dot {{ $i === 0 ? 'bg-white w-3' : '' }}"></div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4">
                        <div class="mb-3 sm:mb-0">
                            <div class="text-xs sm:text-[10px] font-bold text-[#8C6A4F] uppercase tracking-wider sm:tracking-widest mb-1">{{ $room->deskripsi ?: 'Reguler' }}</div>
                            <h3 class="text-xl sm:text-2xl font-bold font-outfit text-gray-900 mb-1 sm:mb-0">Kamar {{ $room->no_kamar }}</h3>
                            <p class="text-sm text-gray-500 sm:mt-1">Full Furnished</p>
                        </div>
                        <div class="flex items-baseline gap-1 sm:block sm:text-right">
                            <span class="text-xl sm:block font-bold text-[#8C6A4F]">{{ $room->formatted_price }}</span>
                            <span class="text-sm sm:text-xs text-gray-500">/ bulan</span>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-6 line-clamp-2 text-sm leading-relaxed">
                        Tipe {{ $room->deskripsi ?: 'Reguler' }} - Hunian nyaman dan bersih dengan fasilitas terbaik untuk kenyamanan aktivitas Anda sehari-hari.
                    </p>
                    <div class="border-t border-gray-100 pt-3 sm:pt-4 flex justify-between items-center">
                        <div class="flex gap-2 text-gray-400">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('room.show', $room->id_room) }}" class="px-4 sm:px-5 py-2 bg-white text-gray-900 border border-gray-200 text-xs sm:text-sm font-semibold rounded-full hover:bg-gray-50 transition">
                                Detail
                            </a>
                            @if ($isBookable)
                                <a href="{{ route('booking.create', ['room_id' => $room->id_room]) }}" class="px-4 sm:px-5 py-2 bg-gray-900 text-white text-xs sm:text-sm font-semibold rounded-full hover:bg-[#8C6A4F] transition">
                                    Book Now
                                </a>
                            @elseif ($room->status === 'perbaikan')
                                <span class="px-4 sm:px-5 py-2 bg-amber-100 text-amber-700 text-xs sm:text-sm font-semibold rounded-full cursor-not-allowed">
                                    Diperbaiki
                                </span>
                            @else
                                <span class="px-4 sm:px-5 py-2 bg-red-100 text-red-600 text-xs sm:text-sm font-semibold rounded-full cursor-not-allowed">
                                    Penuh
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">Maaf, saat ini belum ada kamar yang tersedia.</p>
            </div>
            @endforelse
        </div>

        <!-- Selengkapnya Button -->
        <div id="selengkapnya-container" class="mt-12 text-center" style="display: none;">
            <button id="btn-selengkapnya" class="px-8 py-3 bg-[#8C6A4F] text-white rounded-full font-semibold hover:bg-[#5C4533] transition shadow-md hover:shadow-lg inline-flex items-center gap-2 group">
                <span>Selengkapnya</span>
                <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-y-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Area Sekitar -->
<section id="area-sekitar" class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 gs-fade-up">
            <h2 class="text-4xl font-bold font-outfit text-gray-900 mb-4">Area Di Sekitar Kos</h2>
            <p class="text-gray-600 text-lg">Akses mudah ke berbagai fasilitas umum di sekitar lingkungan.</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 gs-gallery">
            <div class="sm:col-span-2 sm:row-span-2 relative rounded-2xl overflow-hidden group">
                <img src="{{ asset('assets/img/home/kampus.jpg') }}" alt="Kampus" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" loading="lazy" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                    <h3 class="text-white font-bold text-2xl font-outfit">Politeknik Negeri Banyuwangi</h3>
                </div>
            </div>
            <div class="relative rounded-2xl overflow-hidden h-48 group">
                <img src="{{ asset('assets/img/home/cafe.jpg') }}" alt="Cafe" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" loading="lazy" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-4">
                    <h3 class="text-white font-bold font-outfit">Hachi Coffee</h3>
                </div>
            </div>
            <div class="relative rounded-2xl overflow-hidden h-48 group">
                <img src="{{ asset('assets/img/home/puskesmasgitik.jpg') }}" alt="Puskesmas" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" loading="lazy" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-4">
                    <h3 class="text-white font-bold font-outfit">Puskesmas Gitik</h3>
                </div>
            </div>
            <div class="sm:col-span-2 relative rounded-2xl overflow-hidden h-48 group">
                <img src="{{ asset('assets/img/home/stasiunrogojampi.jpg') }}" alt="Stasiun" class="w-full h-full object-cover transition duration-700 group-hover:scale-105" loading="lazy" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-4">
                    <h3 class="text-white font-bold font-outfit">Stasiun Rogojampi</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimoni Section -->
<section id="testimoni" class="py-24 bg-[#5C4533]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 gs-fade-up">
            <div class="text-sm font-bold text-[#D4B59E] uppercase tracking-wider mb-2">Testimoni</div>
            <h2 class="text-4xl font-bold font-outfit text-white">Komentar Pelanggan</h2>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-6">
            @foreach($testimonials as $testi)
            <div class="bg-white rounded-2xl p-6 gs-stagger-testi shadow-xl relative mt-8">
                <div class="absolute -top-8 left-1/2 -translate-x-1/2 w-16 h-16 rounded-full border-4 border-[#5C4533] overflow-hidden bg-[#8C6A4F]">
                    <div class="w-full h-full flex items-center justify-center text-white font-bold text-lg font-outfit select-none">
                        {{ collect(explode(' ', $testi['name']))->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('') }}
                    </div>
                </div>
                <div class="pt-8 text-center">
                    <h4 class="font-bold font-outfit text-gray-900">{{ $testi['name'] }}</h4>
                    <div class="flex justify-center text-yellow-400 my-2">
                        @for($i=0; $i<$testi['rating']; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-600 italic">"{{ $testi['text'] }}"</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        // Hero Image Parallax
        gsap.to(".hero-img", {
            yPercent: 20,
            ease: "none",
            scrollTrigger: {
                trigger: ".hero-img",
                start: "top top",
                end: "bottom top",
                scrub: true
            }
        });

        // Hero Content Fade In
        gsap.from(".gs-hero-content", {
            y: 50,
            opacity: 0,
            duration: 1.5,
            ease: "power3.out"
        });

        // Scroll reveals
        gsap.utils.toArray('.gs-fade-up').forEach(element => {
            gsap.fromTo(element, 
                { y: 50, opacity: 0 },
                {
                    scrollTrigger: {
                        trigger: element,
                        start: "top 85%",
                    },
                    y: 0,
                    opacity: 1,
                    duration: 1,
                    ease: "power3.out"
                }
            );
        });

        gsap.fromTo(".gs-fade-right", 
            { x: -50, opacity: 0 },
            {
                scrollTrigger: {
                    trigger: ".gs-fade-right",
                    start: "top 80%",
                },
                x: 0,
                opacity: 1,
                duration: 1,
                ease: "power3.out"
            }
        );

        gsap.fromTo(".gs-fade-left", 
            { x: 50, opacity: 0 },
            {
                scrollTrigger: {
                    trigger: ".gs-fade-left",
                    start: "top 80%",
                },
                x: 0,
                opacity: 1,
                duration: 1,
                ease: "power3.out"
            }
        );

        // Staggered Cards
        gsap.fromTo(".gs-stagger-card", 
            { y: 50, opacity: 0 },
            {
                scrollTrigger: {
                    trigger: "#why-us",
                    start: "top 80%",
                },
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.2,
                ease: "back.out(1.7)"
            }
        );

        gsap.fromTo(".gs-stagger-room", 
            { y: 50, opacity: 0 },
            {
                scrollTrigger: {
                    trigger: "#tipe-kamar",
                    start: "top 80%",
                },
                y: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.15,
                ease: "power3.out"
            }
        );

        // Selengkapnya Button Logic
        const btnSelengkapnya = document.getElementById('btn-selengkapnya');
        const roomsGrid = document.querySelector('.rooms-grid');
        const containerSelengkapnya = document.getElementById('selengkapnya-container');

        function updateSelengkapnyaButton() {
            if (!roomsGrid || !containerSelengkapnya) return;
            const totalRooms = roomsGrid.querySelectorAll('.room-card-item').length;
            const width = window.innerWidth;
            let limit = 6;
            if (width < 640) {
                limit = 2;
            } else if (width < 1024) {
                limit = 4;
            }

            if (totalRooms <= limit || roomsGrid.classList.contains('is-expanded')) {
                containerSelengkapnya.style.display = 'none';
            } else {
                containerSelengkapnya.style.display = 'block';
            }
        }

        if (btnSelengkapnya && roomsGrid) {
            btnSelengkapnya.addEventListener('click', () => {
                const allItems = Array.from(roomsGrid.querySelectorAll('.room-card-item'));
                const width = window.innerWidth;
                let limit = 6;
                if (width < 640) {
                    limit = 2;
                } else if (width < 1024) {
                    limit = 4;
                }
                const hiddenItems = allItems.slice(limit);

                roomsGrid.classList.add('is-expanded');
                containerSelengkapnya.style.display = 'none';

                if (hiddenItems.length > 0 && typeof gsap !== 'undefined') {
                    gsap.fromTo(hiddenItems, 
                        { y: 30, opacity: 0 },
                        { y: 0, opacity: 1, duration: 0.8, stagger: 0.1, ease: "power3.out" }
                    );
                }
            });

            updateSelengkapnyaButton();
            window.addEventListener('resize', updateSelengkapnyaButton);
        }

        gsap.fromTo(".gs-stagger-testi", 
            { scale: 0.9, opacity: 0 },
            {
                scrollTrigger: {
                    trigger: "#testimoni",
                    start: "top 85%",
                },
                scale: 1,
                opacity: 1,
                duration: 0.6,
                stagger: 0.1,
                ease: "back.out(1.5)"
            }
        );

        // Gallery animations
        gsap.fromTo(".gs-gallery > div", 
            { opacity: 0, scale: 0.95 },
            {
                scrollTrigger: {
                    trigger: "#area-sekitar",
                    start: "top 80%",
                },
                opacity: 1,
                scale: 1,
                duration: 1,
                stagger: 0.1,
                ease: "power2.out"
            }
        );

        // Room Gallery Slideshow (Fade)
        const galleries = document.querySelectorAll('.room-gallery-container');
        galleries.forEach(gallery => {
            const images = gallery.querySelectorAll('.gallery-img');
            const dots = gallery.querySelectorAll('.gallery-dot');
            if (images.length <= 1) return;

            let currentIndex = 0;
            
            setInterval(() => {
                const nextIndex = (currentIndex + 1) % images.length;
                
                // Fade out current
                gsap.to(images[currentIndex], { opacity: 0, duration: 1 });
                if(dots[currentIndex]) dots[currentIndex].classList.remove('bg-white', 'w-3');
                if(dots[currentIndex]) dots[currentIndex].classList.add('bg-white/50');
                
                // Fade in next
                gsap.to(images[nextIndex], { opacity: 1, duration: 1 });
                if(dots[nextIndex]) dots[nextIndex].classList.add('bg-white', 'w-3');
                if(dots[nextIndex]) dots[nextIndex].classList.remove('bg-white/50');
                
                currentIndex = nextIndex;
            }, 4000); // Change image every 4 seconds
        });
    });
</script>
@endpush