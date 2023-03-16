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
        Schema::table('jumlah_kursi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bus')->after('id')->required();
            $table->foreign('id_bus')->references('id')->on('data_bus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jumlah_kursi', function (Blueprint $table) {
            $table->dropForeign('id_bus');
            $table->dropColumn('id_bus');
        });
    }
};
