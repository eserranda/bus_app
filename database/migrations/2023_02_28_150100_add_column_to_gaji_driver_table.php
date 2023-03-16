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
        Schema::table('gaji_driver', function (Blueprint $table) {
            $table->date('date')->after('id');
            $table->string('from_city', 100)->after('id');
            $table->string('to_city', 100)->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gaji_driver', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('from_city');
            $table->dropColumn('to_city');
        });
    }
};