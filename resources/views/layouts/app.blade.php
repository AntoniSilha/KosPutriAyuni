<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kos Putri Ayuni - Hunian Nyaman Khusus Putri')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Kos Putri Ayuni - Hunian nyaman, aman, dan bersih khusus perempuan. Fasilitas lengkap, WiFi gratis, lokasi strategis dekat kampus. Booking online sekarang!')">
    <meta name="keywords" content="kos putri, kos perempuan, kos murah, kos dekat kampus, sewa kamar kos, kos putri ayuni, kos nyaman, boarding house">
    <meta name="author" content="Kos Putri Ayuni">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Kos Putri Ayuni - Hunian Nyaman Khusus Putri')">
    <meta property="og:description" content="@yield('meta_description', 'Kos Putri Ayuni - Hunian nyaman, aman, dan bersih khusus perempuan. Fasilitas lengkap, WiFi gratis, lokasi strategis.')">
    <meta property="og:image" content="{{ asset('assets/img/TampilanKos.jpeg') }}">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Kos Putri Ayuni - Hunian Nyaman Khusus Putri')">
    <meta name="twitter:description" content="@yield('meta_description', 'Kos Putri Ayuni - Hunian nyaman, aman, dan bersih khusus perempuan.')">
    <meta name="twitter:image" content="{{ asset('assets/img/TampilanKos.jpeg') }}">

    <!-- Structured Data (JSON-LD) for Google -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "LodgingBusiness",
        "name": "Kos Putri Ayuni",
        "description": "Hunian nyaman, aman, dan bersih khusus perempuan dengan fasilitas lengkap dan lokasi strategis dekat kampus.",
        "url": "{{ url('/') }}",
        "image": "{{ asset('assets/img/TampilanKos.jpeg') }}",
        "priceRange": "$$",
        "amenityFeature": [
            {"@@type": "LocationFeatureSpecification", "name": "WiFi Gratis"},
            {"@@type": "LocationFeatureSpecification", "name": "CCTV 24 Jam"},
            {"@@type": "LocationFeatureSpecification", "name": "Kamar Mandi Dalam"},
            {"@@type": "LocationFeatureSpecification", "name": "Full Furnished"}
        ]
    }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    


    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .cream-bg { background-color: #FDFBF7; }
        .brown-primary { color: #8C6A4F; }
        .brown-bg { background-color: #8C6A4F; }
        .brown-dark { background-color: #5C4533; }
        
        [v-cloak] { display: none; }
        
        .btn-logout {
            transition: all 0.3s ease;
        }
        
        #mainNav.text-white .btn-logout {
            border-color: rgba(255, 255, 255, 0.6);
            color: white;
        }
        
        #mainNav.text-white .btn-logout:hover {
            background-color: white;
            color: #111827;
            border-color: white;
        }
        
        #mainNav.text-gray-800 .btn-logout {
            border-color: #8C6A4F;
            color: #8C6A4F;
        }
        
        #mainNav.text-gray-800 .btn-logout:hover {
            background-color: #8C6A4F;
            color: white;
        }

        .btn-premium-login {
            background: linear-gradient(135deg, #8C6A4F 0%, #A6866A 100%);
            box-shadow: 0 4px 15px rgba(140, 106, 79, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-premium-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(140, 106, 79, 0.4);
            filter: brightness(1.1);
        }

        .btn-premium-login:active {
            transform: translateY(0);
        }

        /* === Instant Page Transition System === */
        #page-progress {
            position: fixed; top: 0; left: 0; height: 3px; z-index: 9999;
            background: linear-gradient(90deg, #8C6A4F, #A6866A, #C4A882);
            width: 0; opacity: 0;
            transition: width 0.3s ease, opacity 0.15s ease;
            box-shadow: 0 0 8px rgba(140,106,79,0.5);
        }
        #page-progress.active { opacity: 1; }

        .page-content { animation: pageIn 0.25s ease-out; }
        @keyframes pageIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="cream-bg text-gray-800 antialiased overflow-x-hidden">

    <!-- Progress Bar -->
    <div id="page-progress"></div>

    <!-- Navigation -->
    @if(!Route::is('login') && !Route::is('register') && !Route::is('password.request') && !Route::is('password.reset'))
    <nav id="mainNav" class="fixed w-full z-50 transition-all duration-300 {{ Route::is('home') ? 'bg-transparent text-white' : 'glass-nav text-gray-800' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="font-outfit font-bold text-2xl tracking-tight">Kos Ayuni</span>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="font-medium hover:text-[#8C6A4F] transition-colors">Home</a>
                    <a href="{{ route('home') }}#tipe-kamar" class="font-medium hover:text-[#8C6A4F] transition-colors">Tipe Kamar</a>

                    <a href="{{ route('home') }}#about" class="font-medium hover:text-[#8C6A4F] transition-colors">About Us</a>
                    @if(auth()->check() && !auth()->user()->isAdmin())
                        <a href="{{ auth()->user()->booking ? route('pesanan.show', auth()->user()->booking->id_booking) : route('pesanan.index') }}" class="font-medium hover:text-[#8C6A4F] transition-colors">Pesanan</a>
                    @endif
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    @if(auth()->check())

                        @if(auth()->user()->isAdmin())
                            <a href="/admin" class="px-5 py-2 rounded-full font-medium transition-all shadow-md bg-[#8C6A4F] text-white hover:bg-[#5C4533]">Dashboard</a>
                        @else
                            <a href="/dashboard" class="px-5 py-2 rounded-full font-medium transition-all shadow-md bg-[#8C6A4F] text-white hover:bg-[#5C4533]">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-5 py-2 rounded-full border font-medium btn-logout">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-2 px-8 py-2.5 rounded-full text-white font-bold tracking-wider btn-premium-login">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            LOGIN
                        </a>
                    @endif
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobileMenuBtn" class="text-inherit hover:text-gray-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white text-gray-800 border-t">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md font-medium">Home</a>
                <a href="{{ route('home') }}#tipe-kamar" class="block px-3 py-2 rounded-md font-medium">Tipe Kamar</a>
                @if(auth()->check())
                    @if(!auth()->user()->isAdmin())
                        <a href="{{ auth()->user()->booking ? route('pesanan.show', auth()->user()->booking->id_booking) : route('pesanan.index') }}" class="block px-3 py-2 rounded-md font-medium">Pesanan</a>
                        <a href="/dashboard" class="block px-3 py-2 rounded-md font-medium">Dashboard</a>
                    @else
                        <a href="/admin" class="block px-3 py-2 rounded-md font-medium">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md font-medium text-red-600">Logout</button>
                    </form>
                @else
                    <div class="mt-4">
                        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 px-3 py-3.5 rounded-xl font-bold text-white text-center btn-premium-login">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            LOGIN SEKARANG
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </nav>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @if(!Route::is('login') && !Route::is('register') && !Route::is('password.request') && !Route::is('password.reset'))
    <footer class="cream-bg border-t border-gray-200 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-8 h-8 brown-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        <span class="font-outfit font-bold text-2xl">Kos Ayuni</span>
                    </div>
                    <p class="text-gray-600 max-w-sm mt-4">
                        Cari kos dekat dengan apapun? Kos Putri Ayuni jawabannya. Nyaman, aman, khusus perempuan.
                    </p>
                </div>
                <div>
                    <h4 class="font-outfit font-semibold text-lg text-[#8C6A4F] mb-4">Pelayanan</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-[#8C6A4F] transition-colors">Laporan Kerusakan</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-[#8C6A4F] transition-colors">Maps</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-outfit font-semibold text-lg text-[#8C6A4F] mb-4">Follow Us</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-600 hover:text-[#8C6A4F] transition-colors flex items-center gap-2"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg> Facebook</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-[#8C6A4F] transition-colors flex items-center gap-2"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg> Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500">Copyright &copy; {{ date('Y') }}</p>
                <div class="flex gap-4 mt-4 md:mt-0 text-sm text-gray-500">
                    <a href="#" class="hover:text-gray-900">Terms & Conditions</a>
                    <a href="#" class="hover:text-gray-900">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <!-- Notifications -->
    @if(session('success'))
    <div id="toast-success" class="fixed bottom-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg" role="alert" style="z-index: 100;">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>
        </div>
        <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-success" aria-label="Close" onclick="this.parentElement.remove()">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div id="toast-error" class="fixed bottom-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-lg" role="alert" style="z-index: 100;">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/></svg>
        </div>
        <div class="ms-3 text-sm font-normal">{{ session('error') }}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" onclick="this.parentElement.remove()">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/></svg>
        </button>
    </div>
    @endif

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                const menu = document.getElementById('mobileMenu');
                menu.classList.toggle('hidden');
            });
        }

        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (!nav) return;

            const isHome = {{ Route::is('home') ? 'true' : 'false' }};
            
            if (window.scrollY > 50) {
                nav.classList.add('glass-nav', 'text-gray-800');
                if (isHome) nav.classList.remove('bg-transparent', 'text-white');
            } else {
                nav.classList.remove('glass-nav');
                if (isHome) {
                    nav.classList.add('bg-transparent', 'text-white');
                    nav.classList.remove('text-gray-800');
                } else {
                    nav.classList.add('text-gray-800');
                }
            }
        });

        // Auto-hide toasts after 5s
        setTimeout(() => {
            const toasts = document.querySelectorAll('[role="alert"]');
            toasts.forEach(t => t.style.display = 'none');
        }, 5000);
        
        // Initialize GSAP ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);
    </script>

    @stack('scripts')

    <!-- SPA-like Navigation -->
    <script>
    (function(){
        const bar = document.getElementById('page-progress');
        const origin = location.origin;
        let navInProgress = false;

        function showBar(pct){ bar.style.width = pct+'%'; bar.classList.add('active'); }
        function hideBar(){ bar.style.width = '100%'; setTimeout(()=>{ bar.classList.remove('active'); bar.style.width = '0'; }, 200); }

        function shouldIntercept(a){
            if(!a || !a.href) return false;
            if(a.target === '_blank' || a.hasAttribute('download')) return false;
            if(a.href.indexOf(origin) !== 0) return false;
            if(a.closest('form')) return false;
            
            // If current page is an auth page, force full reload to restore layout components like navbar
            const currentPath = location.pathname;
            if(currentPath === '/login' || currentPath === '/register' || currentPath === '/forgot-password' || currentPath.startsWith('/reset-password')) return false;

            // Skip Filament/dashboard/admin panels & payment routes
            const path = a.pathname;
            if(path.startsWith('/admin') || path.startsWith('/dashboard') || path.startsWith('/livewire')) return false;
            if(path.startsWith('/payment')) return false;
            if(path === '/login' || path === '/register' || path === '/forgot-password' || path.startsWith('/reset-password')) return false;
            if(a.href.includes('#') && a.pathname === location.pathname) return false;
            return true;
        }

        document.addEventListener('click', function(e){
            const a = e.target.closest('a');
            if(!a || !shouldIntercept(a) || navInProgress) return;
            e.preventDefault();
            navInProgress = true;
            showBar(30);

            fetch(a.href, {headers:{'X-Requested-With':'SpaNav'}})
            .then(r => { showBar(60); return r.text(); })
            .then(html => {
                showBar(90);
                const doc = new DOMParser().parseFromString(html,'text/html');
                // Swap main content
                const newMain = doc.querySelector('main');
                const oldMain = document.querySelector('main');
                if(newMain && oldMain){
                    oldMain.innerHTML = newMain.innerHTML;
                    oldMain.classList.remove('page-content');
                    void oldMain.offsetWidth; // force reflow
                    oldMain.classList.add('page-content');
                }
                // Update title
                document.title = doc.title;
                // Update nav state
                const newNav = doc.getElementById('mainNav');
                const oldNav = document.getElementById('mainNav');
                if(newNav && oldNav) oldNav.className = newNav.className;
                // Push history
                history.pushState(null,'',a.href);
                window.scrollTo({top:0, behavior:'instant'});
                // Re-run inline scripts in main
                oldMain.querySelectorAll('script').forEach(s=>{
                    const ns = document.createElement('script');
                    if(s.src) ns.src = s.src; else ns.textContent = s.textContent;
                    s.replaceWith(ns);
                });
                hideBar();
                navInProgress = false;
            })
            .catch(()=>{ hideBar(); navInProgress = false; location.href = a.href; });
        });

        window.addEventListener('popstate', ()=> location.reload());
    })();
    </script>
</body>
</html>
