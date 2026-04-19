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
        Schema::create('hotel', function (Blueprint $table) {
            $table->id();
            $table->string('nama_hotel');
            $table->text('alamat');
            $table->text('deskripsi');
            $table->string('rating');
            $table->decimal('harga_per_malam', 12, 2);
            $table->integer('quota')->default(1); 
            $table->integer('booked')->default(0);
            $table->string('foto')->nullable();
            $table->enum('status', ['Tersedia', 'Full Booked'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel');
    }
};
