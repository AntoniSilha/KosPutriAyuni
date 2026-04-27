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
        Schema::table('room_img', function (Blueprint $table) {
            $table->foreign(['rooms_id_room'], 'room_img_ibfk_1')->references(['id_room'])->on('rooms')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_img', function (Blueprint $table) {
            $table->dropForeign('room_img_ibfk_1');
        });
    }
};
