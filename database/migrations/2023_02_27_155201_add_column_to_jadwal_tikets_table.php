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
        Schema::table('jadwal_tikets', function (Blueprint $table) {
            $table->string('sopir_utama', 100)->after('to_city');
            $table->string('sopir_bantu', 100)->after('sopir_utama')->nullable();
            $table->string('kondektur', 100)->after('sopir_bantu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_tikets', function (Blueprint $table) {
            $table->dropColumn('sopir_utama');
            $table->dropColumn('sopir_bantu');
            $table->dropColumn('kondektur');
        });
    }
};
