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
        Schema::create('manufacture_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('manufacture_id');
            $table->unsignedBigInteger('product_id');  $table->integer('qty');
            $table->timestamps();
            // $table->foreign('Manufacture_id')
            //       ->references('id')
            //       ->on('Manufacture')
            //       ->onDelete('cascade');

            // $table->foreign('product_id')
            //       ->references('id')
            //       ->on('products')
            //       ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Manufacture_product');
    }
};
