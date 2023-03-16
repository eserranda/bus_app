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
        Schema::create('jadwal_tikets', function (Blueprint $table) {
            $table->id();
            $table->date('departure_date', 100);
            $table->unsignedBigInteger('id_bus');
            $table->foreign('id_bus')->references('id')->on('data_bus');
            $table->string('route', 100);
            $table->string('price', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_tikets');
    }
};
