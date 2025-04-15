<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('charging_stations', function (Blueprint $table) {
        $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
    });

    Schema::table('discharging_stations', function (Blueprint $table) {
        $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
    });

    Schema::table('shipments', function (Blueprint $table) {
        $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
    });

    Schema::table('vehicle_owners', function (Blueprint $table) {
        $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
    });

    Schema::table('vehicles', function (Blueprint $table) {
        $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
    });

    Schema::table('drivers', function (Blueprint $table) {
        $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
    });
}


    public function down()
    {
        Schema::table('charging_stations', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        Schema::table('discharging_stations', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        Schema::table('shipments', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        Schema::table('vehicle_owners', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });

        Schema::table('drivers', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }

};
