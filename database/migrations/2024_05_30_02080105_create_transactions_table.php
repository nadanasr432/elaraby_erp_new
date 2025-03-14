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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('accounting_tree_id');
            // $table->foreign('accounting_tree_id')->references('id')->on('accounting_trees')->onDelete('cascade');
            $table->unsignedBigInteger('voucher_id');
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('notation')->nullable();
            $table->tinyInteger('type')->comment('0=credit, 1=debit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
