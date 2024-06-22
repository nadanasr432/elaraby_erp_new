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
        Schema::table('extra_settings', function (Blueprint $table) {
            $table->decimal('exp_duration', 8, 2)->nullable()->after('font_size');  // Change 'existing_column' to the column after which you want to add 'exp_duration'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extra_settings', function (Blueprint $table) {
            $table->dropColumn('exp_duration');
        });
    }
};
