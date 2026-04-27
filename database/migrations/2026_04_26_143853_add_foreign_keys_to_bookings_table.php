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
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign(['users_id_user'], 'bookings_ibfk_1')->references(['id_user'])->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['rooms_id_room'], 'bookings_ibfk_2')->references(['id_room'])->on('rooms')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('bookings_ibfk_1');
            $table->dropForeign('bookings_ibfk_2');
        });
    }
};
