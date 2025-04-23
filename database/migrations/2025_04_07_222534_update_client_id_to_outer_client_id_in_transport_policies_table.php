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
        Schema::table('transport_policies', function (Blueprint $table) {
            // Drop the old foreign key and column
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');

            // Define new column correctly
            $table->unsignedBigInteger('outer_client_id')->after('company_id');

            // Add foreign key constraint
            $table->foreign('outer_client_id')
                ->references('id')
                ->on('outer_clients')
                ->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::table('transport_policies', function (Blueprint $table) {
            // Rollback changes
            $table->dropForeign(['outer_client_id']);
            $table->dropColumn('outer_client_id');

            $table->unsignedBigInteger('client_id')->after('company_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }
};