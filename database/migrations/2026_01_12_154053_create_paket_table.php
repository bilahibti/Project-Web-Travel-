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
        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('destinasi_id'); 
            $table->unsignedBigInteger('hotel_id'); 
            $table->unsignedBigInteger('transportasi_id'); 
            $table->string('nama_paket');
            $table->string('durasi');
            $table->decimal('harga', 12, 2);
            $table->integer('quota')->default(1); 
            $table->integer('booked')->default(0);
            $table->enum('status', ['Tersedia', 'Full Booked'])->default('Tersedia');
            $table->timestamps();
            $table->foreign('destinasi_id')->references('id')->on('destinasi'); 
            $table->foreign('hotel_id')->references('id')->on('hotel'); 
            $table->foreign('transportasi_id')->references('id')->on('transportasi'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};
