<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Change the column to have a default value of 'cash'
            $table->string('payment_method')->default('cash')->change();
        });

        // Update all existing records to use the default value
        DB::table('expenses')
        ->whereNull('payment_method')
        ->orWhere('payment_method', '')
        ->update(['payment_method' => 'cash']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert changes in case of rollback
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('payment_method')->default('')->change();
        });
    }
};
