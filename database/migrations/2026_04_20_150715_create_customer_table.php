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
         Schema::create('customer', function (Blueprint $table) { 
            $table->uuid('id')->primary();
            $table->string('nama');
            $table->string('email')->unique(); 
            $table->string('password');
            $table->string('hp', 13);
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('user_id');  
            $table->string('alamat')->nullable(); 
            $table->string('pos')->nullable(); 
            $table->timestamps(); 
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade'); 
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};
