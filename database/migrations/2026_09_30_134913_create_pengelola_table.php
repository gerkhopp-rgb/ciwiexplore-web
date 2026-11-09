<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengelola', function (Blueprint $table) {

            $table->id('id_pengelola');

            $table->unsignedBigInteger('id_user')->unique();

            $table->string('nama_usaha', 100);
            $table->string('no_telepon', 20)->nullable();
            $table->string('alamat', 255);
            $table->string('status', 20)->default('aktif');

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengelola');
    }
};