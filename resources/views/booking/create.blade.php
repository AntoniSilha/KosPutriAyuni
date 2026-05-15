@extends('layouts.app')

@section('title', 'Booking Kamar - Kos Putri Ayuni')

@section('content')
<div class="min-h-screen bg-[#FDFBF7] pt-28 pb-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden gs-fade-up">
            <div class="p-8 border-b border-gray-100 text-center bg-[#8C6A4F] text-white">
                <h2 class="text-3xl font-bold font-outfit">Form Pemesanan Kamar</h2>
                <p class="mt-2 text-white/80">Lengkapi data berikut untuk melakukan pemesanan.</p>
            </div>

            <form action="{{ route('booking.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                @if (session('error'))
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-100 mb-6 flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 p-4 rounded-xl text-sm border border-red-100 mb-6">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-6">
                    <!-- Kamar Selection -->
                    <div>
                        <label for="room_id" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Kamar <span class="text-red-500">*</span></label>
                        <select id="room_id" name="room_id" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-[#8C6A4F] focus:border-[#8C6A4F] bg-gray-50 cursor-pointer">
                            <option value="">-- Pilih Kamar --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id_room }}" {{ (old('room_id') == $room->id_room || ($selectedRoom && $selectedRoom->id_room == $room->id_room)) ? 'selected' : '' }}>
                                    Kamar {{ $room->no_kamar }} - {{ $room->formatted_price }}/bulan
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal Check-in -->
                        <div>
                            <label for="check_in" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                            <input type="date" id="check_in" name="check_in" required min="{{ date('Y-m-d') }}" value="{{ old('check_in', date('Y-m-d')) }}" class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-[#8C6A4F] focus:border-[#8C6A4F] bg-white">
                        </div>

                        <!-- Durasi -->
                        <div>
                            <label for="durasi" class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Durasi Sewa (Bulan) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" id="durasi" name="durasi" required min="1" max="24" value="{{ old('durasi', 1) }}" class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:outline-none focus:ring-[#8C6A4F] focus:border-[#8C6A4F] bg-white">
                                <span class="absolute inset-y-0 right-4 flex items-center text-gray-500 pointer-events-none">Bulan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 font-medium px-4 py-2">Batal</a>
                    <button type="submit" class="px-8 py-3 bg-[#8C6A4F] text-white font-bold rounded-xl shadow-md hover:bg-[#5C4533] hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                        Lanjut ke Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
