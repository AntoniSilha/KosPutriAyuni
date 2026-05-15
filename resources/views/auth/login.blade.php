@extends('layouts.app')

@section('title', 'Login - Kos Putri Ayuni')

@section('content')
<div class="min-h-screen bg-[#f7f2ea] text-slate-900">
    <div class="grid min-h-screen lg:grid-cols-[1.05fr_0.95fr]">
        <section class="relative hidden overflow-hidden bg-[#26382f] lg:block">
            <img src="{{ asset('assets/img/TampilanKos.jpeg') }}" alt="Kos Putri Ayuni" class="absolute inset-0 h-full w-full object-cover opacity-75">
            <div class="absolute inset-0 bg-[#17231d]/55"></div>
            <div class="relative z-10 flex h-full flex-col justify-between p-10 xl:p-14">
                <a href="{{ route('home') }}" class="inline-flex w-fit items-center gap-3 text-white">
                    <span class="grid h-11 w-11 place-items-center rounded-lg bg-white/15 ring-1 ring-white/25">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 11.5 12 4l9 7.5M5.5 10.5V20h13v-9.5M9 20v-5.5h6V20" /></svg>
                    </span>
                    <span>
                        <span class="block font-outfit text-xl font-bold">Kos Putri Ayuni</span>
                        <span class="block text-sm text-white/75">Hunian aman dan nyaman</span>
                    </span>
                </a>

                <div class="max-w-xl text-white">
                    <p class="mb-4 inline-flex rounded-lg bg-white/12 px-4 py-2 text-sm font-semibold ring-1 ring-white/20">Area khusus putri</p>
                    <h1 class="font-outfit text-5xl font-bold leading-tight xl:text-6xl">Masuk untuk mengelola hunian dengan mudah.</h1>
                    <p class="mt-5 max-w-lg text-lg leading-8 text-white/78">Pantau pesanan, data kamar, dan informasi pembayaran dari satu akun yang tertata.</p>
                </div>

                <div class="grid max-w-xl grid-cols-3 gap-3 text-white">
                    <div class="rounded-lg bg-white/12 p-4 ring-1 ring-white/18">
                        <span class="block text-2xl font-bold">24</span>
                        <span class="text-sm text-white/72">Jam aman</span>
                    </div>
                    <div class="rounded-lg bg-white/12 p-4 ring-1 ring-white/18">
                        <span class="block text-2xl font-bold">Rapi</span>
                        <span class="text-sm text-white/72">Data kos</span>
                    </div>
                    <div class="rounded-lg bg-white/12 p-4 ring-1 ring-white/18">
                        <span class="block text-2xl font-bold">Cepat</span>
                        <span class="text-sm text-white/72">Akses akun</span>
                    </div>
                </div>
            </div>
        </section>

        <main class="flex min-h-screen items-center justify-center px-5 py-8 sm:px-8 lg:px-12">
            <div class="w-full max-w-md">
                <div class="mb-6 overflow-hidden rounded-lg bg-[#26382f] shadow-lg lg:hidden">
                    <img src="{{ asset('assets/img/TampilanKos.jpeg') }}" alt="Kos Putri Ayuni" class="h-40 w-full object-cover opacity-85">
                </div>

                <a href="{{ route('home') }}" class="mb-8 inline-flex items-center gap-2 text-sm font-semibold text-[#58735d] hover:text-[#26382f]">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19 3 12m0 0 7-7m-7 7h18" /></svg>
                    Kembali ke beranda
                </a>

                <div class="rounded-lg bg-white p-6 shadow-xl shadow-slate-900/8 ring-1 ring-slate-200 sm:p-8">
                    <div class="mb-8">
                        <p class="mb-2 text-sm font-semibold uppercase tracking-[0.18em] text-[#b9854d]">Login akun</p>
                        <h2 class="font-outfit text-3xl font-bold text-slate-950">Selamat datang</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">Masukkan email dan kata sandi yang sudah terdaftar.</p>
                    </div>

                    <form class="space-y-5" action="{{ route('login') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                                <ul class="space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Alamat email</label>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6.5h16v11H4z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m4 7 8 6 8-6" /></svg>
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                    class="block w-full rounded-md border border-slate-200 bg-slate-50 px-4 py-3 pl-12 text-sm text-slate-900 outline-none transition focus:border-[#58735d] focus:bg-white focus:ring-4 focus:ring-[#58735d]/15"
                                    placeholder="nama@email.com">
                            </div>
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between gap-4">
                                <label for="password" class="block text-sm font-semibold text-slate-700">Kata sandi</label>
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-[#58735d] hover:text-[#26382f]">Lupa sandi?</a>
                            </div>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 10V8a5 5 0 0 1 10 0v2" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 10h12v10H6z" /></svg>
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                    class="block w-full rounded-md border border-slate-200 bg-slate-50 px-4 py-3 pl-12 pr-12 text-sm text-slate-900 outline-none transition focus:border-[#58735d] focus:bg-white focus:ring-4 focus:ring-[#58735d]/15"
                                    placeholder="Masukkan kata sandi">
                                <button type="button" class="absolute right-3 top-1/2 grid h-9 w-9 -translate-y-1/2 place-items-center rounded-md text-slate-500 hover:bg-slate-100 hover:text-[#58735d]" onclick="togglePassword('password')" aria-label="Tampilkan atau sembunyikan kata sandi">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" /></svg>
                                </button>
                            </div>
                        </div>

                        <label class="flex items-center gap-3 text-sm text-slate-600">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-[#58735d] focus:ring-[#58735d]">
                            Ingat saya
                        </label>

                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-md bg-[#58735d] px-5 py-3 text-sm font-bold text-white shadow-lg shadow-[#58735d]/20 transition hover:bg-[#405a46] focus:outline-none focus:ring-4 focus:ring-[#58735d]/25">
                            Masuk sekarang
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6" /></svg>
                        </button>
                    </form>

                    <p class="mt-6 text-center text-sm text-slate-600">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}" class="font-bold text-[#58735d] hover:text-[#26382f]">Daftar akun baru</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection
