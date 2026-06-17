@extends('layouts.app')

@section('title', 'About Us - Kos Putri Ayuni')
@section('meta_description', 'Tentang Kos Putri Ayuni - Hunian nyaman, aman, dan bersih khusus perempuan di Banyuwangi. Cerita kami, visi misi, dan lokasi strategis.')

@section('content')
{{-- Hero Section --}}
<section class="relative h-[60vh] min-h-[400px] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0 bg-gray-900">
        <img src="{{ asset('assets/img/about/hero_bg.jpeg') }}" alt="Kos Putri Ayuni" class="w-full h-full object-cover opacity-40" loading="lazy">
    </div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/50 z-[1]"></div>
    <div class="relative z-10 text-center px-4 max-w-3xl mx-auto">
        <span class="inline-block px-5 py-1.5 bg-[#8C6A4F]/80 text-white text-xs font-bold uppercase tracking-[0.2em] rounded-full mb-6 gs-fade-up">Tentang Kami</span>
        <h1 class="text-white text-3xl sm:text-5xl md:text-6xl font-bold font-outfit mb-5 leading-tight gs-fade-up">
            Lebih dari Sekedar<br>Tempat Singgah
        </h1>
        <p class="text-gray-200 text-base sm:text-lg max-w-xl mx-auto gs-fade-up">
            Menciptakan ruang hidup yang nyaman, aman, dan mendukung produktivitas Anda di jantung Banyuwangi.
        </p>
    </div>
</section>

{{-- Tentang Kami --}}
<section class="py-20 bg-[#FDFBF7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="gs-fade-up">
                <span class="text-sm font-bold text-[#8C6A4F] uppercase tracking-widest">Tentang Kami</span>
                <h2 class="text-3xl sm:text-4xl font-bold font-outfit text-gray-900 mt-2 mb-6">Kos Putri Ayuni</h2>
                <p class="text-gray-600 leading-relaxed mb-5">
                    Berawal dari pemahaman akan kebutuhan hunian yang layak bagi mahasiswa dan profesional muda di Banyuwangi, Kos Ayuni hadir sebagai solusi. Kami percaya bahwa tempat tinggal yang baik adalah fondasi untuk kesuksesan dan kesejahteraan.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Desain kami menggabungkan estetika modern dengan kenyamanan natural, menciptakan lingkungan yang terasa seperti rumah sendiri. Setiap sudut dirancang dengan cermat untuk memberikan keseimbangan antara ruang privat yang tenang dan area komunal yang interaktif.
                </p>
            </div>
            {{-- Carousel Section --}}
            <div class="relative w-full h-[320px] sm:h-[400px] lg:h-[450px] rounded-3xl overflow-hidden shadow-2xl border-4 border-white/60 gs-fade-up group bg-[#FDFBF7]">
                {{-- Carousel Track --}}
                <div id="story-carousel-track" class="flex w-full h-full cursor-grab active:cursor-grabbing select-none" style="transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1);">
                    {{-- Slide 1 --}}
                    <div class="w-full h-full flex-shrink-0 relative">
                        <img src="{{ asset('assets/img/about/interior.jpeg') }}" alt="Interior Kos Putri Ayuni" class="w-full h-full object-cover pointer-events-none select-none" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent pointer-events-none"></div>
                    </div>
                    {{-- Slide 2 --}}
                    <div class="w-full h-full flex-shrink-0 relative">
                        <img src="{{ asset('assets/img/about/fasilitas.png') }}" alt="Fasilitas Kos Putri Ayuni" class="w-full h-full object-cover pointer-events-none select-none" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent pointer-events-none"></div>
                    </div>
                    {{-- Slide 3 --}}
                    <div class="w-full h-full flex-shrink-0 relative">
                        <img src="{{ asset('assets/img/about/lingkungan.jpeg') }}" alt="Lingkungan Kos Putri Ayuni" class="w-full h-full object-cover pointer-events-none select-none" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent pointer-events-none"></div>
                    </div>
                </div>

                {{-- Navigation Buttons --}}
                <button id="story-carousel-prev" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 bg-white/20 hover:bg-[#8C6A4F] backdrop-blur-md text-white border border-white/30 rounded-full flex items-center justify-center transition-all duration-300 opacity-0 group-hover:opacity-100 focus:opacity-100 cursor-pointer shadow-lg hover:scale-110 z-10" aria-label="Slide sebelumnya">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button id="story-carousel-next" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 bg-white/20 hover:bg-[#8C6A4F] backdrop-blur-md text-white border border-white/30 rounded-full flex items-center justify-center transition-all duration-300 opacity-0 group-hover:opacity-100 focus:opacity-100 cursor-pointer shadow-lg hover:scale-110 z-10" aria-label="Slide berikutnya">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </button>

                {{-- Dots Indicators --}}
                <div id="story-carousel-dots" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-2.5 z-10">
                    {{-- Populated dynamically by JS --}}
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Visi & Misi --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 gs-fade-up">
            <span class="text-sm font-bold text-[#8C6A4F] uppercase tracking-widest">Values</span>
            <h2 class="text-3xl sm:text-4xl font-bold font-outfit text-gray-900 mt-2">Visi & Misi</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Card 1 --}}
            <div class="bg-[#FDFBF7] rounded-2xl p-8 border border-gray-100 hover:shadow-lg hover:border-[#8C6A4F]/20 transition-all duration-300 text-center gs-fade-up">
                <div class="w-14 h-14 bg-[#8C6A4F]/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <h3 class="text-xl font-bold font-outfit text-gray-900 mb-3">Kualitas Hunian</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Menyediakan fasilitas premium yang terawat dengan standar kebersihan dan kenyamanan tertinggi untuk setiap penghuni.</p>
            </div>
            {{-- Card 2 --}}
            <div class="bg-[#FDFBF7] rounded-2xl p-8 border border-gray-100 hover:shadow-lg hover:border-[#8C6A4F]/20 transition-all duration-300 text-center gs-fade-up">
                <div class="w-14 h-14 bg-[#8C6A4F]/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-bold font-outfit text-gray-900 mb-3">Keamanan Terjamin</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Menyediakan lingkungan yang aman dengan sistem keamanan 24 jam untuk memberikan ketenangan pikiran bagi penghuni.</p>
            </div>
            {{-- Card 3 --}}
            <div class="bg-[#FDFBF7] rounded-2xl p-8 border border-gray-100 hover:shadow-lg hover:border-[#8C6A4F]/20 transition-all duration-300 text-center gs-fade-up">
                <div class="w-14 h-14 bg-[#8C6A4F]/10 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold font-outfit text-gray-900 mb-3">Komunitas Positif</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Membangun komunitas penghuni yang saling menghargai dan mendukung di antara para penghuni Kos Ayuni.</p>
            </div>
        </div>
    </div>
</section>

{{-- Fasilitas Unggulan --}}
<section class="py-20 bg-[#FDFBF7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 gs-fade-up">
            <span class="text-sm font-bold text-[#8C6A4F] uppercase tracking-widest">Facilities</span>
            <h2 class="text-3xl sm:text-4xl font-bold font-outfit text-gray-900 mt-2">Fasilitas Unggulan</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
            $facilities = [
                ['icon' => 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0', 'title' => 'WiFi Gratis'],
                ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Listrik Gratis'],
                ['icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 'title' => 'CCTV 24 Jam'],
                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Akses 24 Jam'],
                ['icon' => 'M3 7v11a2 2 0 002 2h14a2 2 0 002-2V7M3 7l3-4h12l3 4M3 7h18M8 11h8', 'title' => 'Full Furnished'],
                ['icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z', 'title' => 'Lokasi Strategis'],
            ];
            @endphp
            @foreach($facilities as $f)
            <div class="flex flex-col items-center text-center p-5 bg-white rounded-2xl border border-gray-100 hover:shadow-md hover:border-[#8C6A4F]/20 transition-all duration-300 gs-fade-up">
                <div class="w-12 h-12 bg-[#8C6A4F]/10 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $f['icon'] }}"></path></svg>
                </div>
                <span class="text-sm font-semibold text-gray-900">{{ $f['title'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Lokasi Strategis --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 gs-fade-up">
            <span class="text-sm font-bold text-[#8C6A4F] uppercase tracking-widest">Location</span>
            <h2 class="text-3xl sm:text-4xl font-bold font-outfit text-gray-900 mt-2">Lokasi Strategis</h2>
            <p class="text-gray-600 mt-3 max-w-xl mx-auto">Berada di area Banyuwangi, Kos Ayuni menawarkan akses mudah ke berbagai fasilitas umum, kampus, dan pusat perbelanjaan.</p>
        </div>
        <div class="gs-fade-up">
            <div id="map" class="w-full h-[400px] sm:h-[500px] rounded-2xl overflow-hidden shadow-lg border border-gray-200 z-0"></div>
        </div>
        {{-- Nearby places --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8 gs-fade-up">
            <div class="flex items-center gap-3 bg-[#FDFBF7] rounded-xl p-4 border border-gray-100">
                <div class="w-10 h-10 bg-[#8C6A4F]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Kampus</p>
                    <p class="text-xs text-gray-500">± 5 menit</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-[#FDFBF7] rounded-xl p-4 border border-gray-100">
                <div class="w-10 h-10 bg-[#8C6A4F]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Minimarket</p>
                    <p class="text-xs text-gray-500">± 3 menit</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-[#FDFBF7] rounded-xl p-4 border border-gray-100">
                <div class="w-10 h-10 bg-[#8C6A4F]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">RS / Klinik</p>
                    <p class="text-xs text-gray-500">± 10 menit</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-[#FDFBF7] rounded-xl p-4 border border-gray-100">
                <div class="w-10 h-10 bg-[#8C6A4F]/10 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-[#8C6A4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3zm9 3v12m-6-6h12"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Pusat Kota</p>
                    <p class="text-xs text-gray-500">± 15 menit</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-[#FDFBF7]">
    <div class="max-w-4xl mx-auto px-4 text-center gs-fade-up">
        <h2 class="text-3xl sm:text-4xl font-bold font-outfit text-gray-900 mb-4">Tertarik untuk Bergabung?</h2>
        <p class="text-gray-600 mb-8 max-w-lg mx-auto">Segera booking kamar impian Anda sekarang dan rasakan kenyamanan tinggal di Kos Putri Ayuni.</p>
        <a href="{{ route('home') }}#tipe-kamar" class="inline-flex items-center gap-2 px-8 py-4 bg-[#8C6A4F] text-white rounded-full font-bold text-lg hover:bg-[#5C4533] transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
            Lihat Kamar Tersedia
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
    </div>
</section>
<script>
(function() {
    function initAboutPage() {
        // 1. GSAP Animations
        if (typeof gsap !== 'undefined') {
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.refresh();
            }
            let mm = gsap.matchMedia();
            mm.add("(min-width: 768px)", () => {
                gsap.utils.toArray('.gs-fade-up').forEach(el => {
                    gsap.fromTo(el, { y: 40, opacity: 0 }, {
                        scrollTrigger: { trigger: el, start: "top 90%" },
                        y: 0, opacity: 1, duration: 0.8, ease: "power3.out"
                    });
                });
            });
        }

        // 2. Carousel Slider
        const track = document.getElementById('story-carousel-track');
        if (track) {
            initCarousel(track);
        }

        // 3. Leaflet Map (Lazy loaded on viewport proximity)
        initMapWhenReady();
    }

    function initCarousel(track) {
        const slides = Array.from(track.children);
        const prevBtn = document.getElementById('story-carousel-prev');
        const nextBtn = document.getElementById('story-carousel-next');
        const dotsContainer = document.getElementById('story-carousel-dots');
        
        if (slides.length <= 1) {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            if (dotsContainer) dotsContainer.style.display = 'none';
            return;
        }
        
        let currentIndex = 0;
        let isDragging = false;
        let startX = 0;
        let currentTranslate = 0;
        let autoplayTimer = null;
        
        // Populate dots
        if (dotsContainer) {
            dotsContainer.innerHTML = '';
            slides.forEach((_, i) => {
                const dot = document.createElement('button');
                dot.className = `w-2.5 h-2.5 rounded-full transition-all duration-300 cursor-pointer ${i === 0 ? 'bg-[#8C6A4F] w-6' : 'bg-gray-300 hover:bg-[#8C6A4F]/50'}`;
                dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                dot.addEventListener('click', () => {
                    goToSlide(i);
                    resetAutoplay();
                });
                dotsContainer.appendChild(dot);
            });
        }
        
        const dots = dotsContainer ? Array.from(dotsContainer.children) : [];
        
        function updateCarousel() {
            const translateVal = -currentIndex * 100;
            track.style.transform = `translateX(${translateVal}%)`;
            
            if (dots.length > 0) {
                dots.forEach((dot, i) => {
                    if (i === currentIndex) {
                        dot.className = 'w-6 h-2.5 rounded-full bg-[#8C6A4F] transition-all duration-300 cursor-pointer';
                    } else {
                        dot.className = 'w-2.5 h-2.5 rounded-full bg-gray-300 hover:bg-[#8C6A4F]/50 transition-all duration-300 cursor-pointer';
                    }
                });
            }
        }
        
        function goToSlide(index) {
            currentIndex = index;
            updateCarousel();
        }
        
        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            updateCarousel();
        }
        
        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateCarousel();
        }
        
        if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetAutoplay(); });
        if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetAutoplay(); });
        
        // Drag and Touch Events
        track.addEventListener('touchstart', touchStart, { passive: true });
        track.addEventListener('touchend', touchEnd);
        track.addEventListener('touchmove', touchMove, { passive: true });
        
        track.addEventListener('mousedown', dragStart);
        track.addEventListener('mouseup', dragEnd);
        track.addEventListener('mouseleave', dragEnd);
        track.addEventListener('mousemove', dragMove);
        
        function dragStart(e) {
            isDragging = true;
            startX = e.pageX;
            track.style.transition = 'none';
            stopAutoplay();
        }
        
        function dragEnd() {
            if (!isDragging) return;
            isDragging = false;
            track.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
            
            const movedBy = currentTranslate;
            if (movedBy < -50) {
                nextSlide();
            } else if (movedBy > 50) {
                prevSlide();
            } else {
                updateCarousel();
            }
            currentTranslate = 0;
            resetAutoplay();
        }
        
        function dragMove(e) {
            if (!isDragging) return;
            const currentX = e.pageX;
            const diff = currentX - startX;
            const percent = (diff / track.offsetWidth) * 100;
            const translateVal = -currentIndex * 100 + percent;
            track.style.transform = `translateX(${translateVal}%)`;
            currentTranslate = diff;
        }
        
        function touchStart(e) {
            isDragging = true;
            startX = e.touches[0].clientX;
            track.style.transition = 'none';
            stopAutoplay();
        }
        
        function touchEnd() {
            dragEnd();
        }
        
        function touchMove(e) {
            if (!isDragging) return;
            const currentX = e.touches[0].clientX;
            const diff = currentX - startX;
            const percent = (diff / track.offsetWidth) * 100;
            const translateVal = -currentIndex * 100 + percent;
            track.style.transform = `translateX(${translateVal}%)`;
            currentTranslate = diff;
        }
        
        function startAutoplay() {
            if (autoplayTimer) return;
            autoplayTimer = setInterval(nextSlide, 5000);
        }
        
        function stopAutoplay() {
            if (autoplayTimer) {
                clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        }
        
        function resetAutoplay() {
            stopAutoplay();
            startAutoplay();
        }
        
        startAutoplay();
        
        const carouselContainer = track.parentElement;
        carouselContainer.addEventListener('mouseenter', stopAutoplay);
        carouselContainer.addEventListener('mouseleave', startAutoplay);
    }

    function initMapWhenReady() {
        const mapEl = document.getElementById('map');
        if (!mapEl) return;

        if (typeof window.IntersectionObserver !== 'undefined') {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        observer.disconnect();
                        loadLeafletAssets();
                    }
                });
            }, { rootMargin: '200px' });
            observer.observe(mapEl);
        } else {
            loadLeafletAssets();
        }
    }

    function loadLeafletAssets() {
        if (typeof L !== 'undefined' || document.querySelector('script[src*="leaflet.js"]')) {
            checkAndInitMap();
            return;
        }

        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        link.integrity = 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=';
        link.crossOrigin = '';
        document.head.appendChild(link);

        const script = document.createElement('script');
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        script.integrity = 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=';
        script.crossOrigin = '';
        script.onload = () => {
            initializeMap();
        };
        document.head.appendChild(script);
    }

    function checkAndInitMap() {
        if (typeof L !== 'undefined') {
            initializeMap();
        } else {
            setTimeout(checkAndInitMap, 50);
        }
    }

    function initializeMap() {
        const mapEl = document.getElementById('map');
        if (!mapEl) return;
        
        const map = L.map('map', {
            scrollWheelZoom: false
        }).setView([-8.298672035703198, 114.29870214765783], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            maxZoom: 19
        }).addTo(map);

        const kosIcon = L.divIcon({
            html: '<div style="background:#8C6A4F;width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(140,106,79,0.4);border:3px solid white;"><svg width="18" height="18" fill="white" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></div>',
            className: '',
            iconSize: [36, 36],
            iconAnchor: [18, 36],
            popupAnchor: [0, -36]
        });

        L.marker([-8.298672035703198, 114.29870214765783], { icon: kosIcon })
            .addTo(map)
            .bindPopup('<div style="text-align:center;font-family:Outfit,sans-serif;"><strong style="font-size:14px;">Kos Putri Ayuni</strong><br><span style="color:#666;font-size:12px;">Banyuwangi, Jawa Timur</span><br><a href="https://www.google.com/maps/search/Kos+Putri+Ayuni+Banyuwangi" target="_blank" style="color:#8C6A4F;font-size:12px;font-weight:600;">Buka di Google Maps →</a></div>')
            .openPopup();

        map.on('click', function() { map.scrollWheelZoom.enable(); });
        map.on('mouseout', function() { map.scrollWheelZoom.disable(); });
    }

    // Initialize on ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAboutPage);
    } else {
        initAboutPage();
    }
})();
</script>
@endsection
