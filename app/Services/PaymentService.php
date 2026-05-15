<?php

namespace App\Services;

use App\Events\PaymentReceived;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Generate Midtrans Snap Token
     */
    public function createSnapToken(Booking $booking): string
    {
        $booking->load(['user', 'room']);

        $params = [
            'transaction_details' => [
                'order_id' => $booking->invoice_number,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
                'phone' => $booking->user->no_hp ?? '',
            ],
            'item_details' => [
                [
                    'id' => 'ROOM-'.$booking->rooms_id_room,
                    'price' => (int) $booking->total_price,
                    'quantity' => 1,
                    'name' => 'Sewa Kamar '.($booking->room->no_kamar ?? 'N/A'),
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Create or update payment record
            Payment::updateOrCreate(
                ['bookings_id_booking' => $booking->id_booking],
                [
                    'transaction_id' => $booking->invoice_number,
                    'total_pembayaran' => $booking->total_price,
                    'payment_status' => 'pending',
                    'payment_time' => now(),
                ]
            );

            Log::info('Snap token generated', [
                'booking_id' => $booking->id_booking,
                'invoice' => $booking->invoice_number,
            ]);

            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: '.$e->getMessage(), [
                'booking_id' => $booking->id_booking,
            ]);
            throw $e;
        }
    }

    /**
     * Handle Midtrans callback notification
     */
    public function handleNotification(array $notificationData): Payment
    {
        // Validate signature key
        $this->validateSignature($notificationData);

        $orderId = $notificationData['order_id'];
        $transactionStatus = $notificationData['transaction_status'];
        $paymentType = $notificationData['payment_type'] ?? null;
        $grossAmount = $notificationData['gross_amount'] ?? 0;
        $transactionId = $notificationData['transaction_id'] ?? $orderId;

        Log::info('Midtrans notification received', [
            'order_id' => $orderId,
            'status' => $transactionStatus,
            'payment_type' => $paymentType,
        ]);

        // Find booking by invoice number
        $booking = Booking::where('invoice_number', $orderId)->firstOrFail();

        // Find or create payment
        $payment = Payment::updateOrCreate(
            ['bookings_id_booking' => $booking->id_booking],
            [
                'transaction_id' => $transactionId,
                'payment_method' => $paymentType,
                'total_pembayaran' => $grossAmount,
                'payment_time' => now(),
            ]
        );

        // Map Midtrans status to our payment status
        $paymentStatus = $this->mapTransactionStatus($transactionStatus);
        $payment->update(['payment_status' => $paymentStatus]);

        // Update booking status based on payment
        if ($paymentStatus === 'approve') {
            $booking->update(['status' => 'confirmed']);
            $booking->room->update(['status' => 'tidak tersedia']);

            // Fire payment received event
            event(new PaymentReceived($payment));
        } elseif ($paymentStatus === 'rejected') {
            // Don't cancel the booking yet, let user retry
        }

        return $payment;
    }

    /**
     * Validate Midtrans signature key
     */
    protected function validateSignature(array $data): void
    {
        $orderId = $data['order_id'] ?? '';
        $statusCode = $data['status_code'] ?? '';
        $grossAmount = $data['gross_amount'] ?? '';
        $signatureKey = $data['signature_key'] ?? '';

        $serverKey = config('midtrans.server_key');
        $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Invalid Midtrans signature', [
                'order_id' => $orderId,
            ]);
            throw new \Exception('Invalid signature key');
        }
    }

    /**
     * Map Midtrans transaction status to our payment status
     */
    protected function mapTransactionStatus(string $status): string
    {
        return match ($status) {
            'capture', 'settlement' => 'approve',
            'pending' => 'pending',
            'deny', 'cancel', 'expire' => 'rejected',
            'refund', 'partial_refund' => 'refund',
            default => 'pending',
        };
    }

    /**
     * Manual status check for local development without webhooks
     */
    public function checkStatusManual(string $orderId): ?Payment
    {
        try {
            $status = Transaction::status($orderId);

            if ($status && isset($status->transaction_status)) {
                $booking = Booking::where('invoice_number', $orderId)->first();
                if (! $booking) {
                    return null;
                }

                $paymentStatus = $this->mapTransactionStatus($status->transaction_status);

                $payment = Payment::updateOrCreate(
                    ['bookings_id_booking' => $booking->id_booking],
                    [
                        'transaction_id' => $status->transaction_id ?? $orderId,
                        'payment_method' => $status->payment_type ?? null,
                        'total_pembayaran' => $status->gross_amount ?? $booking->total_price,
                        'payment_status' => $paymentStatus,
                    ]
                );

                if ($paymentStatus === 'approve' && $booking->status !== 'confirmed') {
                    $booking->update(['status' => 'confirmed']);
                    $booking->room->update(['status' => 'tidak tersedia']);
                    event(new PaymentReceived($payment));
                }

                return $payment;
            }
        } catch (\Exception $e) {
            Log::error('Manual status check failed: '.$e->getMessage());
        }

        return null;
    }
}
