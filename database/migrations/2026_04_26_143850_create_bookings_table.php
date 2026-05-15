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
        Schema::create('bookings', function (Blueprint $table) {
            $table->integer('id_booking')->primary()->autoIncrement();
            $table->string('invoice_number', 50)->nullable();
            $table->date('check_in')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'refund'])->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('users_id_user')->nullable()->index('users_id_user');
            $table->integer('rooms_id_room')->nullable()->index('rooms_id_room');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
