<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZatcaCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('zatca_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->text('onboarding_data')->nullable();
            $table->string('last_hash')->nullable();
            $table->integer('sequence')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zatca_companies');
    }
};
