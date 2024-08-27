<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sale_bills', function (Blueprint $table) {
            $table->decimal('total_discount', 10, 2)->default(0);
            $table->decimal('total_tax', 10, 2)->default(0);
            $table->string('products_discount_type')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sale_bills', function (Blueprint $table) {
            $table->dropColumn('total_discount');
            $table->dropColumn('total_tax');
            $table->dropColumn('products_discount_type');
        });
    }
};
