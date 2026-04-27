<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->integer('id_payment')->primary()->autoIncrement();
            $table->string('transaction_id', 100)->nullable();
            $table->string('payment_method', 20)->nullable();
            $table->decimal('total_pembayaran', 10)->nullable();
            $table->enum('payment_status', ['pending', 'approve', 'rejected', 'refund'])->nullable();
            $table->dateTime('payment_time')->nullable();
            $table->integer('bookings_id_booking')->nullable()->index('bookings_id_booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
