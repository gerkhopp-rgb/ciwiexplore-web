<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel destinasi.
     */
    public function up(): void
    {
        Schema::create('destinasi', function (Blueprint $table) {

            $table->id('id_destinasi');

            // Relasi ke tabel kategori
            $table->unsignedBigInteger('id_kategori');

            // Relasi ke tabel pengelola
            // Dibuat nullable sementara untuk MVP
            $table->unsignedBigInteger('id_pengelola')->nullable();

            $table->string('nama_destinasi', 100);

            $table->string('alamat', 255);

            $table->text('deskripsi');

            $table->decimal('harga', 12, 2)->default(0);

            $table->time('jam_buka');

            $table->time('jam_tutup');

            $table->text('fasilitas')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();

            $table->decimal('longitude', 10, 7)->nullable();

            $table->timestamps();


            // Foreign key kategori
            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori')
                ->cascadeOnUpdate()
                ->restrictOnDelete();


            // Foreign key pengelola
            $table->foreign('id_pengelola')
                ->references('id_pengelola')
                ->on('pengelola')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    /**
     * Menghapus tabel destinasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinasi');
    }
};