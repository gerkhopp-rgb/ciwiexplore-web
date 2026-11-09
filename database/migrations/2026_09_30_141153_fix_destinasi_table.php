<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {

            $table->foreign('id_kategori')
                ->references('id')
                ->on('kategoris')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_pengelola')
                ->references('id_pengelola')
                ->on('pengelola')
                ->cascadeOnUpdate()
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('destinasi', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropForeign(['id_pengelola']);
        });
    }
};