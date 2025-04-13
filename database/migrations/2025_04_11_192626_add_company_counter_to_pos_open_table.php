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
        Schema::table('pos_open', function (Blueprint $table) {
            $table->double('company_counter')->nullable(); // Adjust as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos_open', function (Blueprint $table) {
            $table->dropColumn('company_counter');
        });
    }
};
