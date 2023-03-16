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
        Schema::create('gaji_driver', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_driver')->required();
            $table->foreign('id_driver')->references('id')->on('data_driver');
            $table->string('driver_type', 100);
            $table->string('phone', 20);
            $table->string('salary', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_driver');
    }
};
