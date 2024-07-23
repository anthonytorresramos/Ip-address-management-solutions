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
        Schema::table('ip_management', function (Blueprint $table) {
            $table->string('mac_address')->unique()->change();
            $table->string('label')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ip_management', function (Blueprint $table) {
            $table->dropUnique(['mac_address']);
            $table->string('label')->nullable(false)->change();
        });
    }
};
