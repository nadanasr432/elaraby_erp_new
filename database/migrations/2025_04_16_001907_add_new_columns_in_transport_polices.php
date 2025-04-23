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
        Schema::table('transport_policies', function (Blueprint $table) {
            $table->string('sender')->nullable();
            $table->string('receiver')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transport_polices', function (Blueprint $table) {
            $table->dropColumn('sender');
            $table->dropColumn('receiver');
        });
    }
};
