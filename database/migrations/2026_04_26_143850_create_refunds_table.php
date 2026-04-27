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
        Schema::create('refunds', function (Blueprint $table) {
            $table->integer('id_refund')->primary()->autoIncrement();;
            $table->text('reason')->nullable();
            $table->decimal('total', 10)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->nullable();
            $table->dateTime('refund_time')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->integer('payments_id_payment')->nullable()->index('payments_id_payment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
