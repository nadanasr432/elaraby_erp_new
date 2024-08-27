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
        Schema::create('product_stock', function (Blueprint $table) {
            $table->id();
            $table->morphs('stockable');
            $table->foreignId('product_id');
            $table->foreignId('store_id');
            $table->foreignId('company_id');
            $table->integer('remaining');
            $table->integer('qty');
            $table->decimal('net_unit_cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stock');
    }
};
