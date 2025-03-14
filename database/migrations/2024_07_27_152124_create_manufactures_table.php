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
        Schema::create('manufactures', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('store_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->date('date'); // Add this line to handle the date
            $table->integer('number');
            $table->integer('qty');
            $table->text('note')->nullable();
            $table->decimal('total', 10, 2);
            $table->string('status');
            $table->timestamps();

            // $table->foreign('store_id')
            //       ->references('id')
            //       ->on('stores')
            //       ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Manufactures');
    }
};
