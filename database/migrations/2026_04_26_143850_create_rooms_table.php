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
        Schema::create('rooms', function (Blueprint $table) {
            $table->integer('id_room')->primary()->autoIncrement();;
            $table->string('no_kamar', 3)->nullable();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_perbulan', 10)->nullable();
            $table->enum('status', ['tersedia', 'tidak tersedia'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
