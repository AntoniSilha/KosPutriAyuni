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
        Schema::create('billingPenghuni', function (Blueprint $table) {
            $table->integer('id_billing')->autoIncrement();
            $table->date('jatuh_tempo')->nullable();
            $table->integer('payments_id_payment');
            
            $table->foreign('payments_id_payment')->references('id_payment')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billingPenghuni');
    }
};
