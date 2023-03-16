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
        Schema::create('keberangkatan', function (Blueprint $table) {
            $table->id();
            $table->string('from_city', 100);
            $table->string('to_city', 100);
            $table->unsignedBigInteger('id_bus');
            $table->foreign('id_bus')->references('id')->on('data_bus');
            $table->date('date_departure');
            $table->string('time_departure', 50);
            $table->unsignedBigInteger('id_driver');
            $table->foreign('id_driver')->references('id')->on('data_driver');
            $table->string('total_passenger', 100);
            $table->string('status', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keberangkatan');
    }
};
