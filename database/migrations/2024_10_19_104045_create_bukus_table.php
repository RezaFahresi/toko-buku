<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('bukus', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->string('penulis');
        $table->integer('harga');
        $table->integer('stok');
        $table->unsignedBigInteger('kategori_id');  // Foreign key ke tabel kategoris
        $table->timestamps();
    
        // Definisikan relasi foreign key ke tabel kategoris
        $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
    });
    
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
