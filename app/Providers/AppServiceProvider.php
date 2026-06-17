<?php

namespace App\Providers;

use App\Events\BookingCreated;
use App\Events\PaymentReceived;
use App\Listeners\SendBookingNotification;
use App\Listeners\SendPaymentNotification;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Refund;
use App\Policies\BookingPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\RefundPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Policies
        Gate::policy(Booking::class, BookingPolicy::class);
        Gate::policy(Payment::class, PaymentPolicy::class);
        Gate::policy(Refund::class, RefundPolicy::class);

        // Event Listeners are automatically discovered by Laravel 11
        // in the app/Listeners directory.
    }
}
