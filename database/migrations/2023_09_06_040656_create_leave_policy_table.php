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
        Schema::create('leavePolicy', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('paidLeaveCount');
            $table->integer('unpaidLeaveCount');
            $table->string('status')->default('true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leavePolicy');
    }
};