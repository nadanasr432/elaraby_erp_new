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
        Schema::table('sale_bill_elements', function (Blueprint $table) {
            $table->decimal('tax_value', 8, 2)->default(0);
            $table->decimal('discount_value', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sale_bill_elements', function (Blueprint $table) {
            $table->dropColumn('tax_value');
            $table->dropColumn('discount_value');
        });
    }
};
