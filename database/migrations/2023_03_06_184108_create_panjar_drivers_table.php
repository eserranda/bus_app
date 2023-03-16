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
        Schema::create('panjar_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('kode_panjar', 100);
            $table->date('date');
            $table->unsignedBigInteger('id_driver');
            $table->foreign('id_driver')->references('id')->on('data_driver');
            $table->integer('driver_type');
            $table->integer('down_payment');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panjar_drivers');
    }
};
