<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pos_return_elements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pos_return_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('product_price', 15, 2);
            $table->integer('quantity');
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('quantity_price', 15, 2);
            $table->timestamps();

            // Foreign keys
            // $table->foreign('pos_return_id')->references('id')->on('pos_returns')->onDelete('cascade');
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pos_return_elements');
    }
};
