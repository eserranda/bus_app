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
        Schema::table('persenan_gaji', function (Blueprint $table) {
            $table->string('from_city', 100)->after('id');
            $table->string('to_city', 100)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persenan_gaji', function (Blueprint $table) {
            $table->dropColumn('from_city');
            $table->dropColumn('to_city');
        });
    }
};
