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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('projectId');
            $table->unsignedBigInteger('milestoneId');
            $table->unsignedBigInteger('priorityId');
            $table->unsignedBigInteger('taskStatusId');
            $table->string('name');
            $table->dateTime('startDate');
            $table->dateTime('endDate');
            $table->float('completionTime');
            $table->string('description');
            $table->string('status')->default("true");
            $table->timestamps();

            $table->foreign('projectId')->references('id')->on('project')->onDelete('cascade')->onUpdate('cascade');;
            $table->foreign('milestoneId')->references('id')->on('milestone')->onDelete('cascade')->onUpdate('cascade');;
            $table->foreign('priorityId')->references('id')->on('priority')->onDelete('cascade')->onUpdate('cascade');;
            $table->foreign('taskStatusId')->references('id')->on('taskStatus')->onDelete('cascade')->onUpdate('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
