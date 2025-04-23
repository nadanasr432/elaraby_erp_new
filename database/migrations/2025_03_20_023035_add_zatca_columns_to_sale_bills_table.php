<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZatcaColumnsToSaleBillsTable extends Migration
{
    public function up()
    {
        Schema::table('sale_bills', function (Blueprint $table) {
            $table->string('zatca_status')->nullable()->after('status'); // Assuming 'status' exists; adjust column position as needed
            $table->string('zatca_hash')->nullable()->after('zatca_status');
            $table->uuid('uuid')->nullable()->unique()->after('id'); // Adding UUID column, unique for ZATCA
        });
    }

    public function down()
    {
        Schema::table('sale_bills', function (Blueprint $table) {
            $table->dropColumn('zatca_status');
            $table->dropColumn('zatca_hash');
            $table->dropColumn('uuid');
        });
    }
}