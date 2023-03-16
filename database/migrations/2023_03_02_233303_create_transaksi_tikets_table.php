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
        Schema::create('transaksi_tikets', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('from_city', 100);
            $table->string('to_city', 100);
            $table->string('total_ticket', 100);
            $table->string('total_dana', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_tikets');
    }
};
