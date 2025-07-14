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
        Schema::create('m_pinjam', function (Blueprint $table) {
            $table->id('pinjam_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('buku_id')->index();
            $table->date('tanggal_pinjam');
            $table->date('tangga_kembali');
            $table->enum('status', ['dipinjam', 'terlambat', 'selesai']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_pinjam');
    }
};
