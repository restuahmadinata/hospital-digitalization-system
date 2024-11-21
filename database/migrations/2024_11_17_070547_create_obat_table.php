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
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->text('deskripsi');
            $table->enum('tipe_obat', ['keras', 'biasa']);
            $table->integer('stok');
            $table->string('gambar_obat')->nullable();
            $table->date('kedaluwarsa');
            $table->enum('status_kedaluwarsa', ['belum kedaluwarsa', 'kedaluwarsa']);
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};
