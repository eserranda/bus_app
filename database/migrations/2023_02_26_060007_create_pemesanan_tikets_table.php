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
        Schema::create('pemesanan_tikets', function (Blueprint $table) {
            $table->id();
            $table->string('no_ticket', 100)->unique();
            $table->string('customer_name', 100);
            $table->string('seat_number', 100);
            $table->string('from_city', 100);
            $table->string('to_city', 100);
            $table->string('departure_date', 100);
            $table->string('ticket price', 100);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_tikets');
    }
};
