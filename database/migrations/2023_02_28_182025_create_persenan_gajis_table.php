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
        Schema::create('persenan_gaji', function (Blueprint $table) {
            $table->id();
            $table->string('sopir_utama', 50);
            $table->string('sopir_bantu', 50);
            $table->string('kondektur', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persenan_gajis');
    }
};
