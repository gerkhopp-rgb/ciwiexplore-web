<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengelola', function (Blueprint $table) {

            $table->renameColumn('id', 'id_pengelola');

            $table->unsignedBigInteger('id_user')
                ->unique()
                ->after('id_pengelola');

            $table->string('nama_usaha', 100)
                ->after('id_user');

            $table->string('no_telepon', 20)
                ->nullable()
                ->after('nama_usaha');

            $table->string('alamat', 255)
                ->after('no_telepon');

            $table->string('status', 20)
                ->default('aktif')
                ->after('alamat');
        });

        Schema::table('pengelola', function (Blueprint $table) {

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pengelola', function (Blueprint $table) {
            $table->dropForeign(['id_user']);
            $table->dropColumn([
                'id_user',
                'nama_usaha',
                'no_telepon',
                'alamat',
                'status',
            ]);
            $table->renameColumn('id_pengelola', 'id');
        });
    }
};