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
        Schema::create('room_img', function (Blueprint $table) {
            $table->integer('id_image')->primary()->autoIncrement();;
            $table->string('img_url')->nullable();
            $table->integer('rooms_id_room')->nullable()->index('rooms_id_room');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_img');
    }
};
