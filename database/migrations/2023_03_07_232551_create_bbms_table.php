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
        Schema::create('bbms', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('kode_transaksi', 100);
            $table->string('jenis_bbm', 100)->nullable();
            $table->unsignedBigInteger('id_bus');
            $table->foreign('id_bus')->references('id')->on('data_bus');
            $table->integer('jumlah_liter')->nullable();
            $table->integer('total_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbms');
    }
};
