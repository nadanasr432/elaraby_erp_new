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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('leavePolicyId')->nullable();
            $table->unsignedBigInteger('weeklyHolidayId')->nullable();

            $table->foreign('leavePolicyId')->references('id')->on('leavePolicy');
            $table->foreign('weeklyHolidayId')->references('id')->on('weeklyHoliday');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('leavePolicyId');
            $table->dropColumn('weeklyHolidayId');
        });
    }
};
