<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pos_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pos_open_id')->nullable(); // Reference to original POS invoice
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('outer_client_id')->nullable();
            $table->integer('tableNum')->default(0);
            $table->text('notes')->nullable();
            $table->string('status')->default('returned');
            $table->boolean('value_added_tax')->default(1);
            $table->decimal('total_amount', 15, 2);
            $table->decimal('tax_amount', 15, 2)->nullable();
            $table->decimal('tax_value', 15, 2)->nullable();
            $table->integer('company_counter')->nullable();
            $table->timestamp('returned_at')->useCurrent();
            $table->timestamps();

            // Foreign keys
            // $table->foreign('pos_open_id')->references('id')->on('pos_open')->onDelete('set null');
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            // $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            // $table->foreign('outer_client_id')->references('id')->on('outer_clients')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pos_returns');
    }
};
