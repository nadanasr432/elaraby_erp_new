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
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('payment_method'); 
            $table->unsignedBigInteger('bank_id')->nullable()->after('payment_method');
            $table->text('notes')->nullable()->after('payment_method');
            $table->string('payment_no')->nullable()->after('bank_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
        
        });
    }
};
