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
        Schema::create('sessions_ps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boking_id');
            $table->foreign('boking_id')->references('id')->on('bokings')->onDelete('cascade');
            $table->date('tanggal_booking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
