@extends('layouts.app')

@section('title', 'Kamar ' . $room->no_kamar . ' - Kos Putri Ayuni')
@section('meta_description', 'Detail Kamar ' . $room->no_kamar . '. Harga ' . $room->formatted_price . '/bulan. Fasilitas lengkap, WiFi gratis, listrik gratis.')

@php
    $statusBadge = match($room->status) {
        'tersedia' => ['text' => 'Tersedia', 'color' => 'text-green-600 bg-green-50 border-green-200'],
        'tidak tersedia' => ['text' => 'Penuh', 'color' => 'text-red-600 bg-red-50 border-red-200'],
        'perbaikan' => ['text' => 'Sedang Perbaikan', 'color' => 'text-amber-600 bg-amber-50 border-amber-200'],
        default => ['text' => ucfirst($room->status), 'color' => 'text-gray-600 bg-gray-50 border-gray-200'],
    };
    $isBookable = $room->status === 'tersedia';
    $fallbackImg = asset('assets/img/room/room_fallback.jpg');
@endphp

@section('content')
<div class="min-h-screen bg-[#FDFBF7] pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6 gs-fade-up">
            <a href="{{ route('home') }}" class="hover:text-[#8C6A4F] transition-colors">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-gray-900 font-medium">Kamar {{ $room->no_kamar }}</span>
        </nav>

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gs-fade-up">
            <div>
                <div class="text-xs font-bold text-[#8C6A4F] uppercase tracking-widest mb-1">Kamar Putri</div>
                <h1 class="text-3xl sm:text-4xl font-bold font-outfit text-gray-900">Kamar {{ $room->no_kamar }}</h1>
            </div>
            <span class="mt-3 sm:mt-0 inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold border {{ $statusBadge['color'] }}">
                {{ $statusBadge['text'] }}
            </span>
        </div>

        {{-- Image Gallery --}}
        <div class="mb-10 gs-fade-up">
            @php
                $imgCount = $room->images->count();
            @endphp

            @if($imgCount === 0)
                {{-- Fallback: 1 Large Image --}}
                <div class="relative rounded-2xl overflow-hidden h-64 sm:h-80 md:h-[420px] w-full">
                    <img src="{{ $fallbackImg }}" alt="Kamar {{ $room->no_kamar }}" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                </div>
            @elseif($imgCount === 1)
                {{-- 1 Image: Full Width --}}
                <div class="relative rounded-2xl overflow-hidden cursor-pointer group h-64 sm:h-80 md:h-[420px]" onclick="openLightbox(0)">
                    <img src="{{ $room->images[0]->img_url }}" alt="Kamar {{ $room->no_kamar }}" class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-300"></div>
                </div>
            @elseif($imgCount === 2)
                {{-- 2 Images: Split Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 h-64 sm:h-80 md:h-[350px]">
                    @foreach($room->images as $idx => $img)
                        <div class="relative rounded-2xl overflow-hidden cursor-pointer group h-full" onclick="openLightbox({{ $idx }})">
                            <img src="{{ $img->img_url }}" alt="Kamar {{ $room->no_kamar }}" class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-300"></div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- 3+ Images: Premium Grid Layout (1 Large, 2 Small) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 h-64 sm:h-80 md:h-[420px]">
                    {{-- Large main image on the left --}}
                    <div class="md:col-span-2 relative rounded-2xl overflow-hidden cursor-pointer group h-full" onclick="openLightbox(0)">
                        <img src="{{ $room->images[0]->img_url }}" alt="Kamar {{ $room->no_kamar }}" class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-300"></div>
                    </div>
                    
                    {{-- Two smaller side images stacked vertically --}}
                    <div class="grid grid-rows-2 gap-3 h-full hidden md:grid">
                        @foreach($room->images->slice(1, 2) as $idx => $img)
                            <div class="relative rounded-2xl overflow-hidden cursor-pointer group h-full" onclick="openLightbox({{ $idx + 1 }})">
                                <img src="{{ $img->img_url }}" alt="Kamar {{ $room->no_kamar }}" class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-300"></div>
                                {{-- "+X Photos" overlay on the last slot --}}
                                @if($loop->last && $imgCount > 3)
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center pointer-events-none">
                                        <span class="text-white font-bold text-lg">+{{ $imgCount - 3 }} Foto</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- About --}}
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100 gs-fade-up">
                    <h2 class="text-2xl font-bold font-outfit text-gray-900 mb-4">Tentang Kamar</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Kamar {{ $room->no_kamar }} adalah hunian nyaman dan bersih yang dirancang khusus untuk putri. {{ $room->deskripsi ?: 'Dilengkapi dengan perabotan lengkap, kamar ini menawarkan kenyamanan layaknya di rumah sendiri. Lokasi strategis dekat kampus, minimarket, dan fasilitas umum lainnya menjadikan kamar ini pilihan tepat untuk mendukung aktivitas sehari-hari Anda.' }}
                    </p>
                </div>

                {{-- Facilities --}}
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100 gs-fade-up">
                    <h2 class="text-2xl font-bold font-outfit text-gray-900 mb-6">Fasilitas Kamar</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        {{-- 1 Kasur --}}
                        <div class="flex flex-col items-center text-center p-4 bg-[#FDFBF7] rounded-xl border border-gray-100 hover:border-[#8C6A4F]/30 hover:shadow-md transition-all duration-300">
                            <div class="w-12 h-12 bg-[#8C6A4F]/10 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v11a2 2 0 002 2h14a2 2 0 002-2V7M3 7l3-4h12l3 4M3 7h18M8 11h8"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">1 Kasur</span>
                            <span class="text-xs text-gray-500">Single bed</span>
                        </div>
                        {{-- 1 Lemari --}}
                        <div class="flex flex-col items-center text-center p-4 bg-[#FDFBF7] rounded-xl border border-gray-100 hover:border-[#8C6A4F]/30 hover:shadow-md transition-all duration-300">
                            <div class="w-12 h-12 bg-[#8C6A4F]/10 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4h16v16H4V4zm8 0v16M4 12h16"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">1 Lemari</span>
                            <span class="text-xs text-gray-500">Wardrobe</span>
                        </div>
                        {{-- Free WiFi --}}
                        <div class="flex flex-col items-center text-center p-4 bg-[#FDFBF7] rounded-xl border border-gray-100 hover:border-[#8C6A4F]/30 hover:shadow-md transition-all duration-300">
                            <div class="w-12 h-12 bg-[#8C6A4F]/10 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">Free WiFi</span>
                            <span class="text-xs text-gray-500">Tanpa batas</span>
                        </div>
                        {{-- Free Listrik --}}
                        <div class="flex flex-col items-center text-center p-4 bg-[#FDFBF7] rounded-xl border border-gray-100 hover:border-[#8C6A4F]/30 hover:shadow-md transition-all duration-300">
                            <div class="w-12 h-12 bg-[#8C6A4F]/10 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">Free Listrik</span>
                            <span class="text-xs text-gray-500">Gratis bulanan</span>
                        </div>
                    </div>
                </div>

                {{-- Location Info --}}
                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-md border border-gray-100 gs-fade-up">
                    <h2 class="text-2xl font-bold font-outfit text-gray-900 mb-4">Keunggulan Lokasi</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 bg-[#8C6A4F]/10 p-2 rounded-full text-[#8C6A4F]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Dekat Kampus</h4>
                                <p class="text-xs text-gray-500">Akses strategis ke kampus</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 bg-[#8C6A4F]/10 p-2 rounded-full text-[#8C6A4F]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Minimarket</h4>
                                <p class="text-xs text-gray-500">Belanja kebutuhan harian</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 bg-[#8C6A4F]/10 p-2 rounded-full text-[#8C6A4F]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Pelayanan 24 Jam</h4>
                                <p class="text-xs text-gray-500">Bantuan selalu tersedia</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 bg-[#8C6A4F]/10 p-2 rounded-full text-[#8C6A4F]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 text-sm">Keamanan CCTV</h4>
                                <p class="text-xs text-gray-500">Monitoring 24 jam</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Booking Card --}}
            <div class="lg:col-span-1">
                <div class="sticky top-28">
                    <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100 gs-fade-up">
                        <h3 class="text-lg font-bold font-outfit text-gray-900 mb-2">Mulai Booking</h3>
                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-3xl font-bold text-[#8C6A4F]">{{ $room->formatted_price }}</span>
                        <span class="text-sm text-gray-500">/ bulan</span>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Full Furnished
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            WiFi & Listrik Gratis
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Keamanan 24 Jam
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Pembayaran Online
                        </div>
                    </div>

                    @if($isBookable)
                        <a href="{{ route('booking.create', ['room_id' => $room->id_room]) }}" class="block w-full py-3.5 bg-[#8C6A4F] text-white text-center font-bold rounded-xl shadow-md hover:bg-[#5C4533] hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            Book Now
                        </a>
                    @elseif($room->status === 'perbaikan')
                        <div class="w-full py-3.5 bg-amber-100 text-amber-700 text-center font-bold rounded-xl cursor-not-allowed">
                            Dalam Perbaikan
                        </div>
                    @else
                        <div class="w-full py-3.5 bg-red-100 text-red-600 text-center font-bold rounded-xl cursor-not-allowed">
                            Kamar Penuh
                        </div>
                    @endif

                    <p class="text-xs text-gray-400 text-center mt-4">Harga belum termasuk deposit. Hubungi admin untuk info lebih lanjut.</p>
                </div>
                </div>
            </div>
        </div>

        {{-- Kamar Lainnya --}}
        @if($otherRooms->count() > 0)
        <div class="mt-16 gs-fade-up">
            <h2 class="text-2xl sm:text-3xl font-bold font-outfit text-gray-900 mb-8">Kamar Lainnya</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @foreach($otherRooms as $other)
                @php
                    $otherStatus = match($other->status) {
                        'tersedia' => ['text' => 'Tersedia', 'color' => 'text-green-600 bg-green-50 border-green-100'],
                        'tidak tersedia' => ['text' => 'Penuh', 'color' => 'text-red-600 bg-red-50 border-red-100'],
                        'perbaikan' => ['text' => 'Perbaikan', 'color' => 'text-amber-600 bg-amber-50 border-amber-100'],
                        default => ['text' => ucfirst($other->status), 'color' => 'text-gray-600 bg-gray-50 border-gray-100'],
                    };
                @endphp
                <a href="{{ route('room.show', $other->id_room) }}" class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 group block">
                    <div class="relative h-40 overflow-hidden">
                        <img src="{{ $other->images->first()?->img_url ?: $fallbackImg }}" alt="Kamar {{ $other->no_kamar }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                        <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-xs font-bold border {{ $otherStatus['color'] }}">
                            {{ $otherStatus['text'] }}
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="text-xs font-bold text-[#8C6A4F] uppercase tracking-wider mb-1">Kamar Putri</div>
                        <h3 class="text-lg font-bold font-outfit text-gray-900 mb-1">Kamar {{ $other->no_kamar }}</h3>
                        <div class="flex items-baseline gap-1">
                            <span class="font-bold text-[#8C6A4F]">{{ $other->formatted_price }}</span>
                            <span class="text-xs text-gray-500">/ bulan</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 z-[100] bg-black/90 hidden items-center justify-center" onclick="closeLightbox()">
    <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white/80 hover:text-white z-10">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
    @if($room->images->count() > 1)
    <button onclick="event.stopPropagation(); changeSlide(-1)" class="absolute left-4 text-white/80 hover:text-white z-10">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    <button onclick="event.stopPropagation(); changeSlide(1)" class="absolute right-4 text-white/80 hover:text-white z-10">
        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>
    @endif
    <img id="lightbox-img" src="" alt="" class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg" onclick="event.stopPropagation()">
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // GSAP Animations
    let mm = gsap.matchMedia();
    mm.add("(min-width: 768px)", () => {
        gsap.utils.toArray('.gs-fade-up').forEach(el => {
            gsap.fromTo(el, { y: 40, opacity: 0 }, {
                scrollTrigger: { trigger: el, start: "top 90%" },
                y: 0, opacity: 1, duration: 0.8, ease: "power3.out"
            });
        });
    });
});

// Lightbox
const images = @json($room->images->pluck('img_url')->toArray());
let currentSlide = 0;

function openLightbox(idx) {
    if (!images.length) return;
    currentSlide = idx;
    const lb = document.getElementById('lightbox');
    document.getElementById('lightbox-img').src = images[idx];
    lb.classList.remove('hidden');
    lb.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lb = document.getElementById('lightbox');
    lb.classList.add('hidden');
    lb.classList.remove('flex');
    document.body.style.overflow = '';
}

function changeSlide(dir) {
    currentSlide = (currentSlide + dir + images.length) % images.length;
    document.getElementById('lightbox-img').src = images[currentSlide];
}

document.addEventListener('keydown', e => {
    if (document.getElementById('lightbox').classList.contains('hidden')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') changeSlide(-1);
    if (e.key === 'ArrowRight') changeSlide(1);
});
</script>
@endpush
