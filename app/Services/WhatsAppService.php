<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send WhatsApp message
     */
    public function send(string $phone, string $message): bool
    {
        if (! config('whatsapp.enabled')) {
            Log::info('WhatsApp disabled, message not sent', [
                'phone' => $phone,
                'message' => $message,
            ]);

            return false;
        }

        try {
            return $this->sendViaFonnte($phone, $message);
        } catch (\Exception $e) {
            Log::error('WhatsApp send failed: '.$e->getMessage(), [
                'phone' => $phone,
            ]);

            return false;
        }
    }

    /**
     * Send via Fonnte
     */
    protected function sendViaFonnte(string $phone, string $message): bool
    {
        $response = Http::withHeaders([
            'Authorization' => config('whatsapp.fonnte.api_token'),
        ])->post(config('whatsapp.fonnte.api_url'), [
            'target' => $phone,
            'message' => $message,
        ]);

        Log::info('Fonnte response', [
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

        return $response->successful();
    }

    /**
     * Notify admin about a successful transaction (Booking + Payment Combined)
     */
    public function notifyAdminPaymentReceived(string $userName, string $room, string $amount, string $invoice): bool
    {
        $adminPhone = config('whatsapp.admin_phone');
        if (empty($adminPhone)) {
            Log::warning('Admin phone not configured, skipping admin notification.');

            return false;
        }

        $appUrl = config('app.url', 'http://127.0.0.1:8000');
        $dashboardUrl = rtrim($appUrl, '/').'/admin';

        $message = "🎉 *TRANSAKSI KOS BARU BERHASIL* 🎉\n"
            ."━━━━━━━━━━━━━━━━━━━━━━\n\n"
            ."Telah masuk pembayaran baru dengan rincian:\n\n"
            ."👤 *Penyewa* : {$userName}\n"
            ."🏠 *Kamar*   : {$room}\n"
            ."💵 *Total*   : *{$amount}*\n"
            ."🧾 *Invoice* : {$invoice}\n"
            ."✅ *Status*  : LUNAS (Midtrans)\n"
            .'🕐 *Waktu*   : '.now()->format('d M Y, H:i')."\n\n"
            ."━━━━━━━━━━━━━━━━━━━━━━\n"
            ."Untuk melihat detail pesanan dan manajemen penghuni, silakan klik tautan dashboard di bawah ini:\n\n"
            ."👉 🌐 *Buka Dashboard Admin* 🌐 👈\n"
            ."🔗 {$dashboardUrl}\n\n"
            .'_Pesan otomatis oleh Sistem Kos Putri Ayuni_';

        return $this->send($adminPhone, $message);
    }
}
