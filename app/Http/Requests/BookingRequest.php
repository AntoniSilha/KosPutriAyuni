<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && !auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'room_id' => ['required', 'integer', 'exists:rooms,id_room'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'durasi' => ['required', 'integer', 'min:1', 'max:24'],
        ];
    }

    public function messages(): array
    {
        return [
            'room_id.required' => 'Pilih kamar terlebih dahulu.',
            'room_id.exists' => 'Kamar tidak ditemukan.',
            'check_in.required' => 'Tanggal check-in wajib diisi.',
            'check_in.after_or_equal' => 'Tanggal check-in minimal hari ini.',
            'durasi.required' => 'Durasi sewa wajib diisi.',
            'durasi.min' => 'Durasi sewa minimal 1 bulan.',
        ];
    }
}
